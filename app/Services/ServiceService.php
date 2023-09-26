<?php

namespace App\Services;

use App\DTO\Airport\AirportBaseDto;
use App\DTO\GettSleep\GettSleepServiceDto;
use App\DTO\GettSleep\GettSleepServiceFilterDto;
use App\DTO\GettSleep\GettSleepTariffDto;
use App\DTO\Language\LanguageBaseDto;
use App\DTO\PaginatedDtoCollection;
use App\DTO\Service\ServiceBaseDto;
use App\DTO\Service\ServiceFilterDto;
use App\DTO\Service\ServiceSearchResultDto;
use App\DTO\Service\ServiceSearchResultItemDto;
use App\DTO\ServiceType\ServiceTypeBaseDto;
use App\DTO\Terminal\TerminalBaseDto;
use App\Repositories\Interfaces\AirportRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\ServiceDataRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Interfaces\ServiceTariffRepositoryInterface;
use App\Repositories\Interfaces\ServiceTypeRepositoryInterface;
use App\Repositories\Interfaces\TerminalRepositoryInterface;
use App\Services\Interfaces\GettSleepApiServiceInterface;
use App\Services\Interfaces\ServiceServiceInterface;
use Closure;
use Illuminate\Support\Collection;

class ServiceService extends BaseService implements ServiceServiceInterface
{
    /**
     * @param ServiceRepositoryInterface $repository
     * @param GettSleepApiServiceInterface $gettSleepApiService
     * @param AirportRepositoryInterface $airportRepository
     * @param TerminalRepositoryInterface $terminalRepository
     * @param LanguageRepositoryInterface $languageRepository
     * @param ServiceTypeRepositoryInterface $serviceTypeRepository
     * @param ServiceDataRepositoryInterface $serviceDataRepository
     * @param ServiceTariffRepositoryInterface $serviceTariffRepository
     */
    public function __construct(
        private ServiceRepositoryInterface $repository,
        private GettSleepApiServiceInterface $gettSleepApiService,
        private AirportRepositoryInterface $airportRepository,
        private TerminalRepositoryInterface $terminalRepository,
        private LanguageRepositoryInterface $languageRepository,
        private ServiceTypeRepositoryInterface $serviceTypeRepository,
        private ServiceDataRepositoryInterface $serviceDataRepository,
        private ServiceTariffRepositoryInterface $serviceTariffRepository
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param int|string $airportId
     * @param ServiceFilterDto $filter
     * @param null|array|string $relations
     * @param null|int $limit
     * @return ServiceSearchResultDto
     */
    public function searchInAirport(int|string $airportId, ServiceFilterDto $filter, null|array|string $relations = null, null|int $limit = null): ServiceSearchResultDto
    {
        $relations = collect($relations);
        if (!$relations->contains('type.data')) {
            $relations->push('type.data');
        }

        $items = collect();
        $services = $this->repository->searchInAirport($airportId, $filter, $relations->all());

        $services->groupBy('typeId')
            ->each(function ($value) use ($items, $limit) {
                $items->push(
                    new ServiceSearchResultItemDto([
                        'type' => $value->first()->type,
                        'total' => $value->count(),
                        'items' => $limit ? $value->take($limit) : $value,
                    ])
                );
            });

        return new ServiceSearchResultDto(['total' => $services->count(), 'items' => $items]);
    }

    /**
     * @param int|string $airportId
     * @param null|ServiceFilterDto $filter
     * @param null|array|string $relations
     * @param null|int|Closure $perPage
     * @param string $pageName
     * @param null|int $page
     * @return Collection|PaginatedDtoCollection
     */
    public function findByAirportId(int|string $airportId, ?ServiceFilterDto $filter = null, null|array|string $relations = null, null|int|Closure $perPage = null, string $pageName = 'page', ?int $page = null): Collection|PaginatedDtoCollection
    {
        return $this->repository->findByAirportId($airportId, $filter, $relations, $perPage, $pageName, $page);
    }

    /**
     * @return void
     */
    public function synchronizeWithGettSleepApi()
    {
        $airports = $this->airportRepository->all();

        /** @var AirportBaseDto $airport */
        foreach ($airports as $airport) {
            $filter = new GettSleepServiceFilterDto(['iata' => $airport->iata]);
            $gettSleepServices = $this->gettSleepApiService->getServices($filter);

            /** @var GettSleepServiceDto $gettSleepService */
            foreach ($gettSleepServices as $gettSleepService) {
                $type = $this->serviceTypeRepository->find($gettSleepService->type, 'slug');
                if (!$type) {
                    continue;
                }

                $terminal = null;
                if ($gettSleepService->terminal) {
                    $terminal = $this->terminalRepository->firstOrCreate([
                        'airport_id' => $airport->id,
                        'name' => $gettSleepService->terminal,
                    ]);
                }

                $service = $this->createFromGettSleepService($gettSleepService, $type, $airport, $terminal);
                if ($gettSleepService->childServices) {
                    /** @var GettSleepServiceDto $gettSleepChildService */
                    foreach ($gettSleepService->childServices as $gettSleepChildService) {
                        $this->createFromGettSleepService($gettSleepChildService, $type, $airport, $terminal, $service->id);
                    }
                }
            }
        }
    }

    /**
     * @param GettSleepServiceDto $gettSleepService
     * @param ServiceTypeBaseDto $type
     * @param AirportBaseDto $airport
     * @param null|TerminalBaseDto $terminal
     * @param null|int $parentId
     * @return ServiceBaseDto
     */
    private function createFromGettSleepService(
        GettSleepServiceDto $gettSleepService,
        ServiceTypeBaseDto $type,
        AirportBaseDto $airport,
        ?TerminalBaseDto $terminal = null,
        ?int $parentId = null): ServiceBaseDto
    {
        /** @var ServiceBaseDto $service */
        $service = $this->repository->firstOrCreate(
            ['gettsleep_id' => $gettSleepService->id],
            [
                'parent_id' => $parentId,
                'type_id' => $type->id,
                'airport_id' => $airport->id,
                'terminal_id' => $terminal?->id,
                'image' => is_array($gettSleepService->photos) ? collect($gettSleepService->photos)->first() : null,
                'count' => $gettSleepService->count,
                'gettsleep_id' => $gettSleepService->id,
            ]
        );

        if ($gettSleepService->availableTariffs) {
            /** @var GettSleepTariffDto $gettSleepTariff */
            foreach ($gettSleepService->availableTariffs as $gettSleepTariff) {
                $this->serviceTariffRepository->firstOrCreate(
                    [
                        'service_id' => $service->id,
                        'gettsleep_id' => $gettSleepTariff->id,
                    ],
                    [
                        'service_id' => $service->id,
                        'duration' => $gettSleepTariff->duration,
                        'price' => $gettSleepTariff->adultPrice,
                        'gettsleep_id' => $gettSleepTariff->id,
                    ]
                );
            }
        }

        /** @var LanguageBaseDto $language */
        foreach ($this->languageRepository->all() as $language) {
            $localized = $this->gettSleepApiService->getService($service->gettSleepId, $language->code);

            $this->serviceDataRepository->firstOrCreate(
                [
                    'service_id' => $service->id,
                    'lang_id' => $language->id,
                ],
                [
                    'service_id' => $service->id,
                    'lang_id' => $language->id,
                    'name' => $localized->name,
                    'description' => $localized->description,
            ]);
        }

        return $service;
    }
}

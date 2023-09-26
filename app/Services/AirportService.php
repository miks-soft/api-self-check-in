<?php

namespace App\Services;

use App\DTO\Airport\AirportBaseDto;
use App\DTO\Country\CountryBaseDto;
use App\DTO\GettSleep\GettSleepAirportDto;
use App\Repositories\Interfaces\AirportRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\TerminalRepositoryInterface;
use App\Services\Interfaces\AirportServiceInterface;
use Illuminate\Support\Collection;

class AirportService extends BaseService implements AirportServiceInterface
{
    /**
     * @param AirportRepositoryInterface $repository
     * @param GettSleepApiService $gettSleepApiService
     * @param CountryRepositoryInterface $countryRepository
     * @param TerminalRepositoryInterface $terminalRepository
     */
    public function __construct(
        private AirportRepositoryInterface $repository,
        private GettSleepApiService $gettSleepApiService,
        private CountryRepositoryInterface $countryRepository,
        private TerminalRepositoryInterface $terminalRepository
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param int|string $countryId
     * @return Collection
     */
    public function findByCountryId(int|string $countryId): Collection
    {
        return $this->repository->findByCountryId($countryId);
    }

    /**
     * @return void
     */
    public function synchronizeWithGettSleepApi()
    {
        $jsonCountries = collect(json_decode(file_get_contents(storage_path('countries.json'))));
        $gettSleepAirports = $this->gettSleepApiService->getAirports();

        /** @var GettSleepAirportDto $gettSleepAirport */
        foreach ($gettSleepAirports as $gettSleepAirport) {
            $jsonCountry = $jsonCountries->first(fn ($item) => $item->abbreviation === $gettSleepAirport->countryCode);
            if (!$jsonCountry) {
                continue;
            }

            /** @var CountryBaseDto $country */
            $country = $this->countryRepository->firstOrCreate(['name' => $jsonCountry->country]);

            /** @var AirportBaseDto $airport */
            $airport = $this->repository->firstOrCreate(
                ['iata' => $gettSleepAirport->iata],
                [
                    'country_id' => $country->id,
                    'iata' => $gettSleepAirport->iata,
                    'name' => $gettSleepAirport->name,
                ]
            );

            /** @var GettSleepTerminalDto $gettSleepTerminal */
            foreach ($gettSleepAirport->terminals as $gettSleepTerminal) {
                $this->terminalRepository->firstOrCreate(['airport_id' => $airport->id, 'name' => $gettSleepTerminal->name]);
            }
        }
    }
}

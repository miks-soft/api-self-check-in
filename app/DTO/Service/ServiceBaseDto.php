<?php

namespace App\DTO\Service;

use App\DTO\Airport\AirportBaseDto;
use App\DTO\BaseDto;
use App\DTO\ServiceType\ServiceTypeBaseDto;
use App\DTO\Terminal\TerminalBaseDto;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class ServiceBaseDto extends BaseDto
{
    public int $id;
    #[MapFrom('parent_id')]
    public ?int $parentId;
    #[MapFrom('type_id')]
    public int $typeId;
    public ?ServiceTypeBaseDto $type;
    #[MapFrom('airport_id')]
    public int $airportId;
    public ?AirportBaseDto $airport;
    #[MapFrom('terminal_id')]
    public ?int $terminalId;
    public ?TerminalBaseDto $terminal;
    public ?string $slug;
    public ?string $image;
    public ?int $count;
    #[MapFrom('gettsleep_id')]
    public ?string $gettSleepId;
    #[MapFrom('created_at')]
    public Carbon $createdAt;
    #[MapFrom('updated_at')]
    public Carbon $updatedAt;
    #[CastWith(ArrayCaster::class, ServiceDataBaseDto::class)]
    public ?Collection $data;
    #[CastWith(ArrayCaster::class, ServiceTariffBaseDto::class)]
    public ?Collection $tariffs;
    #[CastWith(ArrayCaster::class, ServiceBaseDto::class)]
    public ?Collection $children;

    /**
     * @param null|int $duration
     * @return null|ServiceTariffBaseDto
     */
    public function getTariff(?int $duration = null): ?ServiceTariffBaseDto
    {
        /** @var ?ServiceTariffBaseDto $tariff */
        $tariff = $this->tariffs?->first();

        return $tariff;
    }
}

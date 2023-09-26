<?php

namespace App\DTO\Service;

use App\DTO\BaseDto;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ServiceFilterDto extends BaseDto
{
    #[MapFrom('type_id')]
    public ?array $typeId;
    #[MapFrom('terminal_id')]
    public ?int $terminalId;
    #[MapFrom('date_from')]
    public ?Carbon $dateFrom;
    #[MapFrom('date_to')]
    public ?Carbon $dateTo;
    public ?int $duration;
}

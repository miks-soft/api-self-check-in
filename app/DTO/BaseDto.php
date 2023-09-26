<?php

namespace App\DTO;

use App\DTO\Casters\CarbonCaster;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\DefaultCast;
use Spatie\DataTransferObject\DataTransferObject;

#[DefaultCast(Carbon::class, CarbonCaster::class)]
abstract class BaseDto extends DataTransferObject {}

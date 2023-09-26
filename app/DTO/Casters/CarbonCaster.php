<?php

namespace App\DTO\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class CarbonCaster implements Caster
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function cast(mixed $value): mixed
    {
        return new Carbon($value);
    }
}

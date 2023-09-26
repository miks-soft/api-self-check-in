<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;

class GettSleepTerminalDto extends BaseDto
{
    public string $id;
    public string $airportIata;
    public string $name;
    public ?string $description;
}

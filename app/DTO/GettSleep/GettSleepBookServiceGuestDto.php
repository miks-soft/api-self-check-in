<?php

namespace App\DTO\GettSleep;

use App\DTO\BaseDto;
use Carbon\Carbon;

class GettSleepBookServiceGuestDto extends BaseDto
{
    public string $firstName;
    public ?string $lastName;
    public string $phone;
    public string $email;
    public Carbon $birthday;
}

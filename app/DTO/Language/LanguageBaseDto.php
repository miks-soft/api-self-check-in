<?php

namespace App\DTO\Language;

use App\DTO\BaseDto;

class LanguageBaseDto extends BaseDto
{
    public int $id;
    public string $code;
    public string $name;
}

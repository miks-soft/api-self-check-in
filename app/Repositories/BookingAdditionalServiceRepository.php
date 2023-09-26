<?php

namespace App\Repositories;

use App\DTO\Booking\BookingAdditionalServiceBaseDto;
use App\Models\BookingAdditionalService;
use App\Repositories\Interfaces\BookingAdditionalServiceRepositoryInterface;

class BookingAdditionalServiceRepository extends BaseEloquentRepository implements BookingAdditionalServiceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(BookingAdditionalService::class, BookingAdditionalServiceBaseDto::class);
    }
}

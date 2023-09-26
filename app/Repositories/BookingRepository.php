<?php

namespace App\Repositories;

use App\DTO\Booking\BookingBaseDto;
use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository extends BaseEloquentRepository implements BookingRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Booking::class, BookingBaseDto::class);
    }
}

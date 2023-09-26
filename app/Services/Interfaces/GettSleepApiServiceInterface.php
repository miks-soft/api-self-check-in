<?php

namespace App\Services\Interfaces;

use App\DTO\GettSleep\GettSleepBookServiceDto;
use App\DTO\GettSleep\GettSleepBookServiceResponseDto;
use App\DTO\GettSleep\GettSleepCancelBookingResponseDto;
use App\DTO\GettSleep\GettSleepServiceDto;
use App\DTO\GettSleep\GettSleepServiceFilterDto;
use Illuminate\Support\Collection;

interface GettSleepApiServiceInterface
{
    /**
     * @return Collection
     */
    public function getAirports(): Collection;

    /**
     * @param null|GettSleepServiceFilterDto $filter
     * @return Collection
     */
    public function getServices(?GettSleepServiceFilterDto $filter = null): Collection;

    /**
     * @param string $id
     * @param null|string $lang
     * @return GettSleepServiceDto
     */
    public function getService(string $id, ?string $lang = null): GettSleepServiceDto;

    /**
     * @param GettSleepBookServiceDto $data
     * @return GettSleepBookServiceResponseDto
     */
    public function bookService(GettSleepBookServiceDto $data): GettSleepBookServiceResponseDto;

    /**
     * @param string $id
     * @return GettSleepCancelBookingResponseDto
     */
    public function cancelBooking(string $id): GettSleepCancelBookingResponseDto;
}

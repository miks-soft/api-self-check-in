<?php

namespace App\Services;

use App\DTO\GettSleep\GettSleepAirportDto;
use App\DTO\GettSleep\GettSleepBookServiceDto;
use App\DTO\GettSleep\GettSleepBookServiceResponseDto;
use App\DTO\GettSleep\GettSleepCancelBookingResponseDto;
use App\DTO\GettSleep\GettSleepServiceDto;
use App\DTO\GettSleep\GettSleepServiceFilterDto;
use App\Services\Interfaces\GettSleepApiServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GettSleepApiService implements GettSleepApiServiceInterface
{
    private string $url;
    private string $usr;
    private string $pwd;
    private string $token;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->url = config('services.gettsleep_api.url');
        $this->usr = config('services.gettsleep_api.username');
        $this->pwd = config('services.gettsleep_api.password');
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getAirports(): Collection
    {
        $this->auth();

        $res = Http::withoutVerifying()
            ->withToken($this->token)
            ->get($this->url.'/v2/airports');

        if (!$res->successful()) {
            throw new Exception(
                'Error getting airports from GettSleep API service'
            );
        }

        return collect($res->json())
            ->map(fn ($airport) => new GettSleepAirportDto($airport));
    }

    /**
     * @param null|GettSleepServiceFilterDto $filter
     * @return Collection
     * @throws Exception
     */
    public function getServices(?GettSleepServiceFilterDto $filter = null): Collection
    {
        $this->auth();

        $res = Http::withoutVerifying()
            ->withToken($this->token)
            ->timeout(600)
            ->get($this->url.'/v2/services', $filter?->toArray());

        if (!$res->successful()) {
            throw new Exception(
                'Error getting services from GettSleep API service'
            );
        }

        return collect($res->json())
            ->map(fn ($service) => new GettSleepServiceDto($service));
    }

    /**
     * @param string $id
     * @param null|string $lang
     * @return GettSleepServiceDto
     * @throws Exception
     */
    public function getService(string $id, ?string $lang = null): GettSleepServiceDto
    {
        $this->auth();

        $res = Http::withoutVerifying()
            ->withToken($this->token)
            ->get($this->url.'/v2/services/'.$id, ['lang' => $lang]);

        if (!$res->successful()) {
            throw new Exception(
                'Error getting service from GettSleep API service'
            );
        }

        return new GettSleepServiceDto($res->json());
    }

    /**
     * @param GettSleepBookServiceDto $data
     * @return GettSleepBookServiceResponseDto
     * @throws Exception
     */
    public function bookService(GettSleepBookServiceDto $data): GettSleepBookServiceResponseDto
    {
        $this->auth();

        $res = Http::withoutVerifying()
            ->withToken($this->token)
            ->post($this->url.'/v2/bookings', $data->toArray());

        if (!$res->successful()) {
            throw new Exception(
                'Error booking service in GettSleep API service'
            );
        }

        return new GettSleepBookServiceResponseDto($res->json());
    }

    /**
     * @param string $id
     * @return GettSleepCancelBookingResponseDto
     * @throws Exception
     */
    public function cancelBooking(string $id): GettSleepCancelBookingResponseDto
    {
        $this->auth();

        $res = Http::withoutVerifying()
            ->withToken($this->token)
            ->post($this->url.'/v2/bookings/'.$id.'/cancel');

        if (!$res->successful()) {
            throw new Exception(
                'Error cancelling booking in GettSleep API service'
            );
        }

        return new GettSleepCancelBookingResponseDto($res->json());
    }

    /**
     * @return void
     * @throws Exception
     */
    private function auth()
    {
        $res = Http::withoutVerifying()
            ->post($this->url.'/v2/auth', [
                'username' => $this->usr,
                'password' => $this->pwd,
            ]);

        if ($res->successful()) {
            $this->token = $res->json('token');
        } else {
            throw new Exception(
                'Error authenticating GettSleep API service'
            );
        }
    }
}

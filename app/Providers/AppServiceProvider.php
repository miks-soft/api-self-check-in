<?php

namespace App\Providers;

use App\Repositories\AirportRepository;
use App\Repositories\BookingAdditionalServiceRepository;
use App\Repositories\BookingRepository;
use App\Repositories\CountryRepository;
use App\Repositories\Interfaces\AirportRepositoryInterface;
use App\Repositories\Interfaces\BookingAdditionalServiceRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\ServiceDataRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Interfaces\ServiceTariffRepositoryInterface;
use App\Repositories\Interfaces\ServiceTypeDataRepositoryInterface;
use App\Repositories\Interfaces\ServiceTypeRepositoryInterface;
use App\Repositories\Interfaces\TerminalRepositoryInterface;
use App\Repositories\LanguageRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ServiceDataRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceTariffRepository;
use App\Repositories\ServiceTypeDataRepository;
use App\Repositories\ServiceTypeRepository;
use App\Repositories\TerminalRepository;
use App\Services\AirportService;
use App\Services\BookingService;
use App\Services\CountryService;
use App\Services\GettSleepApiService;
use App\Services\Interfaces\AirportServiceInterface;
use App\Services\Interfaces\BookingServiceInterface;
use App\Services\Interfaces\CountryServiceInterface;
use App\Services\Interfaces\GettSleepApiServiceInterface;
use App\Services\Interfaces\LanguageServiceInterface;
use App\Services\Interfaces\PaymentServiceInterface;
use App\Services\Interfaces\PaymentSystemServiceInterface;
use App\Services\Interfaces\ServiceServiceInterface;
use App\Services\Interfaces\ServiceTypeServiceInterface;
use App\Services\LanguageService;
use App\Services\PaymentService;
use App\Services\PaytureService;
use App\Services\ServiceService;
use App\Services\ServiceTypeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GettSleepApiServiceInterface::class, GettSleepApiService::class);
        $this->app->bind(PaymentSystemServiceInterface::class, PaytureService::class);

        $this->app->bind(LanguageServiceInterface::class, LanguageService::class);
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
        $this->app->bind(AirportServiceInterface::class, AirportService::class);
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);
        $this->app->bind(ServiceTypeServiceInterface::class, ServiceTypeService::class);
        $this->app->bind(BookingServiceInterface::class, BookingService::class);
        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);

        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(AirportRepositoryInterface::class, AirportRepository::class);
        $this->app->bind(TerminalRepositoryInterface::class, TerminalRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ServiceDataRepositoryInterface::class, ServiceDataRepository::class);
        $this->app->bind(ServiceTypeRepositoryInterface::class, ServiceTypeRepository::class);
        $this->app->bind(ServiceTypeDataRepositoryInterface::class, ServiceTypeDataRepository::class);
        $this->app->bind(ServiceTariffRepositoryInterface::class, ServiceTariffRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(BookingAdditionalServiceRepositoryInterface::class, BookingAdditionalServiceRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Console\Commands;

use App\Services\Interfaces\AirportServiceInterface;
use App\Services\Interfaces\ServiceServiceInterface;
use Illuminate\Console\Command;

class SynchronizeWithGettSleepApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gettsleep:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize DB with GettSleep API';

    /**
     * Execute the console command.
     *
     * @param AirportServiceInterface $airportService
     * @param ServiceServiceInterface $serviceService
     * @return int
     */
    public function handle(
        AirportServiceInterface $airportService,
        ServiceServiceInterface $serviceService
    )
    {
        $this->line('Synchronizing airports...');
        $airportService->synchronizeWithGettSleepApi();
        $this->info('Done.');

        $this->line('Synchronizing services...');
        $serviceService->synchronizeWithGettSleepApi();
        $this->info('Done.');

        return Command::SUCCESS;
    }
}

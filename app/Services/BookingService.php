<?php

namespace App\Services;

use App\DTO\Booking\BookingBaseDto;
use App\DTO\Booking\BookingCreateAdditionalServiceDto;
use App\DTO\Booking\BookingCreateDto;
use App\DTO\GettSleep\GettSleepBookServiceContactDto;
use App\DTO\GettSleep\GettSleepBookServiceDto;
use App\DTO\GettSleep\GettSleepBookServiceGuestDto;
use App\DTO\GettSleep\GettSleepBookServiceResponseDto;
use App\DTO\Payment\PaymentBaseDto;
use App\DTO\Service\ServiceBaseDto;
use App\Enums\PaymentEnum;
use App\Enums\PriceCurrencyEnum;
use App\Repositories\Interfaces\BookingAdditionalServiceRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\Interfaces\BookingServiceInterface;
use App\Services\Interfaces\PaymentSystemServiceInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class BookingService extends BaseService implements BookingServiceInterface
{
    /**
     * @param BookingRepositoryInterface $repository
     * @param GettSleepApiService $gettSleepApiService
     * @param ServiceRepositoryInterface $serviceRepository
     * @param PaymentSystemServiceInterface $paymentSystemService
     * @param BookingAdditionalServiceRepositoryInterface $bookingAdditionalServiceRepository
     */
    public function __construct(
        private BookingRepositoryInterface $repository,
        private GettSleepApiService $gettSleepApiService,
        private ServiceRepositoryInterface $serviceRepository,
        private PaymentSystemServiceInterface $paymentSystemService,
        private BookingAdditionalServiceRepositoryInterface $bookingAdditionalServiceRepository
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param int|string $serviceId
     * @param BookingCreateDto $data
     * @param null|string $returnUrl
     * @return PaymentBaseDto|BookingBaseDto
     * @throws Exception
     */
    public function bookService(int|string $serviceId, BookingCreateDto $data, ?string $returnUrl = null): PaymentBaseDto|BookingBaseDto
    {
        /** @var ServiceBaseDto $service */
        $service = $this->serviceRepository->findWith($serviceId, 'tariffs', 'id', ['*'], true);

        $tariff = $service->getTariff($data->duration);
        if (!$tariff || !$tariff->price) {
            throw new Exception('Can\'t book service without price');
        }

        /** @var BookingBaseDto $booking */
        $booking = DB::transaction(function () use ($data, $service, $tariff) {
            $addtls = [];

            $data->additional?->each(
                function (BookingCreateAdditionalServiceDto $addtl) use ($data, $service, &$addtls) {
                    /** @var ServiceBaseDto $child */
                    $child = $this->serviceRepository->findWith($addtl->serviceId, 'tariffs', 'id', ['*'], true);

                    if ($child->parentId !== $service->id) {
                        throw new Exception(
                            "Service with ID {$child->id} is not additional for service with ID {$service->id}"
                        );
                    }

                    $tariff = $child->getTariff($data->duration);
                    $price = $tariff ? $tariff->price : 0;

                    $addtls[] = [
                        'service_id' => $child->id,
                        'count' => $addtl->count,
                        'price' => $price,
                        'total' => $price * $addtl->count,
                        'currency' => PriceCurrencyEnum::RUB,
                    ];
                }
            );

            $totalAddtl = array_reduce($addtls, fn ($carry, $addtl) => $carry + $addtl['total'], 0);
            $total = $data->count * ($tariff->price + $totalAddtl);

            /** @var BookingBaseDto $booking */
            $booking = $this->repository->create([
                'service_id' => $service->id,
                'date_from' => $data->dateFrom,
                'date_to' => $data->dateTo,
                'duration' => $data->duration,
                'name' => $data->name,
                'last_name' => $data->lastName,
                'phone' => $data->phone,
                'email' => $data->email,
                'age' => $data->age,
                'flight' => $data->flight,
                'departure' => $data->departure,
                'payment' => $data->payment,
                'count' => $data->count,
                'price' => $tariff->price,
                'total' => $total,
                'currency' => PriceCurrencyEnum::RUB,
            ]);

            foreach ($addtls as $addtl) {
                $addtl['booking_id'] = $booking->id;
                $this->bookingAdditionalServiceRepository->create($addtl);
            }

            return $booking;
        });

        /** @var BookingBaseDto $booking */
        $booking = $this->repository->findWith($booking->id, ['service.data', 'additional.service.data']);

        /** @var GettSleepBookServiceResponseDto $res */
        $res = $this->gettSleepApiService->bookService(
            new GettSleepBookServiceDto([
                'serviceId' => $service->gettSleepId,
                'tariffId' => $tariff->gettSleepId,
                'flight' => $booking->flight,
                'count' => $booking->count,
                'arrival' => $booking->dateFrom,
                'departure' => $booking->departure,
                'contact' => new GettSleepBookServiceContactDto([
                    'name' => $booking->name.' '.$booking->lastName,
                    'phone' => $booking->phone,
                    'email' => $booking->email,
                ]),
                'guests' => [
                    new GettSleepBookServiceGuestDto([
                        'firstName' => $booking->name,
                        'lastName' => $booking->lastName,
                        'phone' => $booking->phone,
                        'email' => $booking->email,

                        // TODO: temp. solution
                        'birthday' => Carbon::now()->subYears(35),
                    ]),
                ],
            ])
        );

        $this->repository->update($booking->id, [
            'gettsleep_id' => $res->id,
            'gettsleep_status' => $res->status,
        ]);

        if ($data->payment === PaymentEnum::CARD) {
            return $this->paymentSystemService->init($booking, $returnUrl);
        }

        return $booking;
    }
}

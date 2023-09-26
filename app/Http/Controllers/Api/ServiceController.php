<?php

namespace App\Http\Controllers\Api;

use App\DTO\Booking\BookingCreateDto;
use App\DTO\Payment\PaymentBaseDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingCreateRequest;
use App\Http\Resources\Booking\BookingViewResource;
use App\Http\Resources\Payment\PaymentViewResource;
use App\Http\Resources\Service\ServiceViewResource;
use App\Http\Resources\ServiceType\ServiceTypeListResource;
use App\Services\BookingService;
use App\Services\Interfaces\ServiceServiceInterface;
use App\Services\Interfaces\ServiceTypeServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @group Services
 */
class ServiceController extends Controller
{
    /**
     * @param ServiceServiceInterface $service
     * @param BookingService $bookingService
     * @param ServiceTypeServiceInterface $serviceTypeService
     */
    public function __construct(
        private ServiceServiceInterface $service,
        private BookingService $bookingService,
        private ServiceTypeServiceInterface $serviceTypeService
    )
    {
    }

    /**
     * List all service types
     *
     * @return JsonResource
     *
     * @queryParam lang string Example: en
     * @responseFile storage/responses/service-type/success.service-type.list.json
     */
    public function listTypes(): JsonResource
    {
        return ServiceTypeListResource::collection($this->serviceTypeService->allWith('data'));
    }

    /**
     * View service by ID
     *
     * @param int $id
     * @return JsonResource
     *
     * @queryParam lang string Example: en
     * @queryParam duration integer Example: 24
     * @responseFile storage/responses/service/success.service.view.json
     */
    public function show(int $id): JsonResource
    {
        return new ServiceViewResource($this->service->findByIdWith($id, [
            'data',
            'type.data',
            'airport',
            'terminal',
            'tariffs',
            'children.data',
            'children.type.data',
            'children.airport',
            'children.terminal',
            'children.tariffs',
        ]));
    }

    /**
     * Book service by ID
     *
     * @param int $id
     * @param BookingCreateRequest $request
     * @return JsonResource
     * @throws UnknownProperties
     *
     * @header X-Return-Url http://payment/return/url/example
     * @queryParam lang string Example: en
     * @responseFile scenario="Payment" storage/responses/payment/success.payment.view.json
     * @responseFile scenario="Service booked" storage/responses/booking/success.booking.view.json
     */
    public function book(int $id, BookingCreateRequest $request): mixed
    {
        $res = $this->bookingService->bookService(
            $id, new BookingCreateDto($request->validated()), $request->header('X-Return-Url')
        );

        return $res instanceof PaymentBaseDto ? new PaymentViewResource($res) : new BookingViewResource($res);
    }
}

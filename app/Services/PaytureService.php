<?php

namespace App\Services;

use App\DTO\Booking\BookingBaseDto;
use App\DTO\Language\LanguageBaseDto;
use App\DTO\Payment\PaymentBaseDto;
use App\DTO\Service\ServiceDataBaseDto;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\PaymentException;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\Interfaces\PaymentSystemServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaytureService implements PaymentSystemServiceInterface
{
    public string $url;
    public string $key;
    public string $returnUrl;
    public ?LanguageBaseDto $language;

    /**
     * @param PaymentRepositoryInterface $paymentRepository
     * @param LanguageRepositoryInterface $languageRepository
     */
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private LanguageRepositoryInterface $languageRepository
    )
    {
        $this->url = config('services.payture.url');
        $this->key = config('services.payture.key');
        $this->returnUrl = config('services.payture.return_url');
        $this->language = $this->languageRepository->find(app()->getLocale(), 'code');
    }

    /**
     * @param BookingBaseDto $booking
     * @param null|string $returnUrl
     * @return PaymentBaseDto
     * @throws PaymentException
     */
    public function init(BookingBaseDto $booking, ?string $returnUrl = null): PaymentBaseDto
    {
        /** @var ?ServiceDataBaseDto $serviceData */
        $serviceData = null;

        if ($this->language) {
            $serviceData = $booking->service?->data?->where('langId', $this->language->id)->first();
        }

        $id = Str::uuid();
        $url = $returnUrl ?? $this->returnUrl;

        $data = [
            'Key' => $this->key,
            'Data' => urlencode(
                'SessionType=Pay'
                .';OrderId='.$id
                .';Amount='.($booking->total * 100)
                .';Url='.$url.'?Success=True&OrderId='.$id
                .';Product='.substr($serviceData?->name, 0, 50)
                .';Total='.$booking->total
                .';Phone='.str_replace('+', '', $booking->phone)
            ),
        ];

        $res = Http::asForm()->post($this->url.'/apim/Init', $data);
        if (!$res->successful()) {
            throw new PaymentException(
                'Error requesting Payture service'
            );
        }

        $parsed = simplexml_load_string($res->body());
        if (!$parsed || (string)$parsed->attributes()->Success !== 'True') {
            throw new PaymentException(
                'Payment error. Check payment data or try again later'
            );
        }

        return $this->paymentRepository->create([
            'uuid' => $id,
            'booking_id' => $booking->id,
            'url' => $this->url.'/apim/Pay?SessionId='.$parsed->attributes()->SessionId,
            'status' => PaymentStatusEnum::NEW,
        ]);
    }

    /**
     * @param string $paymentUuid
     * @return PaymentBaseDto
     * @throws PaymentException
     */
    public function complete(string $paymentUuid): PaymentBaseDto
    {
        /** @var PaymentBaseDto $payment */
        $payment = $this->paymentRepository->find($paymentUuid, 'uuid', ['*'], true);

        $data = [
            'Key' => $this->key,
            'OrderId' => $payment->uuid,
        ];

        $res = Http::asForm()->post($this->url.'/apim/PayStatus', $data);
        if (!$res->successful()) {
            throw new PaymentException(
                'Error requesting Payture service'
            );
        }

        $parsed = simplexml_load_string($res->body());
        if (!$parsed || (string)$parsed->attributes()->Success !== 'True') {
            throw new PaymentException(
                'Payment error. Check payment data or try again later'
            );
        }

        return $this->paymentRepository->update($payment->id, [
            'status' => (string)$parsed->attributes()->State === 'Charged' ? PaymentStatusEnum::SUCCESSFUL : PaymentStatusEnum::ERROR,
        ], true);
    }
}

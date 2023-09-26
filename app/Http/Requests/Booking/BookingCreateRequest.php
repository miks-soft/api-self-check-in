<?php

namespace App\Http\Requests\Booking;

use App\Enums\AgeEnum;
use App\Enums\PaymentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @bodyParam date_from string required Example: 2022-10-20T11:20:17.000000Z
 * @bodyParam date_to string required Example: 2022-10-21T11:20:17.000000Z
 * @bodyParam duration integer required Example: 24
 * @bodyParam name string required Example: John
 * @bodyParam last_name string required Example: Doe
 * @bodyParam phone string required Example: +123456789
 * @bodyParam email string required Example: john.doe@email.com
 * @bodyParam age string required Must be one of: adult,child,infant Example: adult
 * @bodyParam flight string required Example: BA2490
 * @bodyParam departure string required Example: 2022-10-21T11:20:17.000000Z
 * @bodyParam payment string required Must be one of: card,cash Example: card
 * @bodyParam count integer required Example: 2
 * @bodyParam additional object[]
 * @bodyParam additional[].service_id integer required Example: 1
 * @bodyParam additional[].count integer required Example: 2
 */
class BookingCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date'],
            'duration' => ['required', 'integer', 'min:1', 'max:720'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\+?[1-9][0-9]{1,14}$/'],
            'email' => ['required', 'email'],
            'age' => ['required', Rule::in(AgeEnum::values())],
            'flight' => ['required', 'string', 'max:255'],
            'departure' => ['required', 'date'],
            'payment' => ['required', Rule::in(PaymentEnum::values())],
            'count' => ['required', 'integer', 'min:1', 'max:100'],
            'additional' => ['array'],
            'additional.*.service_id' => ['required', 'integer', 'exists:services,id'],
            'additional.*.count' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}

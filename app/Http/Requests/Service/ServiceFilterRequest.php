<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Query parameters
 */
class ServiceFilterRequest extends FormRequest
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
            'type_id' => ['array'],
            'type_id.*' => ['integer'],
            'terminal_id' => ['integer'],
            'date_from' => ['date'],
            'date_to' => ['date'],
            'duration' => ['integer', 'min:1', 'max:720'],
        ];
    }
}

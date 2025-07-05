<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['string','min:8', 'required', 'date_format:d-m-Y H:i:s'],
            'end_date' =>  ['string','min:8', 'required', 'date_format:d-m-Y H:i:s', 'after:start_date'],
            'room' => ['integer', 'required'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();

        throw new HttpResponseException(
            response()->json([
                'errors' => $errors,
                'message' => 'The given data was invalid.',
            ], 422)
        );
    }

}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:180', 'min:5'],
            'roles' => ['nullable'],
            'email'=> ['email'],
            'password' => ['confirmed' , Password::min(5)->uncompromised()]
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

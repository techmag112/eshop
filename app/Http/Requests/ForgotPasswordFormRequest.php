<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле обязательное',
            'email.email' => 'Неверный формат почтового адреса',

        ];
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }

}

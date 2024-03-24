<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignUpFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательное',
            'email.required' => 'Поле обязательное',
            'password.required' => 'Поле обязательное',
            'password.confirmed' => 'Пароли не совпадают',
            'email.email' => 'Неверный формат почтового адреса',
            'password.min' => 'Длина пароля минимум 8 символов',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str(request('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}

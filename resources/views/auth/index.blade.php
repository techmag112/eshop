@extends('layouts.auth')

@section('title', 'Вход в аккаунт')

@section('content')
    <x-forms.auth-form
        title="Вход в аккаунт"
        action="{{ route('signIn') }}"
        method="POST"
    >

       @csrf

       <x-forms.text-input
           type="email"
           name="email"
           placeholder="E-mail"
           required="true"
           value="{{ old('email') }}"
           :isError="$errors->has('email')"
       />

       @error('email')
       <x-forms.error>
           {{ $message }}
       </x-forms.error>
       @enderror

       <x-forms.text-input
           type="password"
           name="password"
           placeholder="Пароль"
           required="true"
           :isError="$errors->has('email')"
       />

       <x-forms.primary-button>
           Войти
       </x-forms.primary-button>

       <x-slot:socialAuth>
           <x-forms.git-auth/>
       </x-slot:socialAuth>

       <x-slot:buttons>
           <div class="space-y-3 mt-5">
               <x-forms.link-route route='password.forgot' title='Забыли пароль?'/>
               <x-forms.link-route route='sign-up' title='Регистрация'/>
           </div>
       </x-slot:buttons>

   </x-forms.auth-form>
@endsection

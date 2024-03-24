@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
   <x-forms.auth-form
       title="Регистрация"
       action="{{ route('register.handle') }}"
       method="POST"
   >

       @csrf

       <x-forms.text-input type="text"
                           name="name"
                           placeholder="Имя"
                           value="{{ old('name') }}"
                           required
                           :isError="$errors->has('name')">
       </x-forms.text-input>

       @error('name')
       <x-forms.error>
           {{ $message }}
       </x-forms.error>
       @enderror

       <x-forms.text-input type="email"
                           name="email"
                           placeholder="E-mail"
                           value="{{ old('email') }}"
                           required
                           :isError="$errors->has('email')">
       </x-forms.text-input>

       @error('email')
       <x-forms.error>
           {{ $message }}
       </x-forms.error>
       @enderror

       <x-forms.text-input type="password"
                           name="password"
                           placeholder="Пароль"
                           required
                           :isError="$errors->has('password')">
       </x-forms.text-input>

       @error('password')
       <x-forms.error>
           {{ $message }}
       </x-forms.error>
       @enderror

       <x-forms.text-input type="password"
                           name="password_confirmation"
                           placeholder="Повторите пароль"
                           required
                           :isError="$errors->has('password_confirmation')">
       </x-forms.text-input>

       @error('password_confirmation')
       <x-forms.error>
           {{ $message }}
       </x-forms.error>
       @enderror

       <x-forms.primary-button>
           Зарегестрироваться
       </x-forms.primary-button>

       <x-slot:socialAuth>
           <x-forms.git-auth/>
       </x-slot:socialAuth>

       <x-slot:buttons>
           <div class="space-y-3 mt-5">
               <x-forms.link-route route='login' title='Войти в аккаунт'/>
           </div>
       </x-slot:buttons>

   </x-forms.auth-form>
@endsection

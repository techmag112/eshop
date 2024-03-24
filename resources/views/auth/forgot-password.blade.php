@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')
   <x-forms.auth-form
       title="Забыли пароль"
       action="{{ route('forgot.handle') }}"
       method="POST"
   >

       @csrf

       <x-forms.text-input type="email"
                           name="email"
                           placeholder="E-mail"
                           required
                           :isError="$errors->has('email')"
       />

       @error('email')
        <x-forms.error>
           {{ $message }}
        </x-forms.error>
       @enderror

       <x-forms.primary-button>
           Отправить
       </x-forms.primary-button>

       <x-slot:socialAuth>
       </x-slot:socialAuth>

       <x-slot:buttons>
           <div class="space-y-3 mt-5">
               <x-forms.link-route route='login' title='Вспомнил пароль'/>
           </div>
       </x-slot:buttons>

   </x-forms.auth-form>
@endsection

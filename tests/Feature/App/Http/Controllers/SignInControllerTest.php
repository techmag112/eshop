<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignUpFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertSee('E-mail')
            ->assertSee('Пароль')
            ->assertSee('Войти')
            ->assertSee('Забыли пароль?')
            ->assertSee('Регистрация')
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function it_login_submit_success(): void
    {
        $password = '123456789';
        $user = UserFactory::new()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(
            action([SignInController::class, 'handle']),
            $request
        );

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);

    }

    /** @test */
    public function it_logout_page_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => fake()->email,
        ]);
        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

    /** @test */
    public function it_login_submit_error_with_invalid_email(): void
    {
        $password = '123456789';
        $request = SignInFormRequest::factory()->create([
            'email' => 'testing',
            'password' => bcrypt($password),
        ]);

        $this->post(
            action([SignInController::class, 'handle']),
            $request
        )->assertInvalid(['email']);

    }

    /** @test */
    public function it_login_submit_error_with_invalid_password(): void
    {
        $password = '123';
        $request = SignInFormRequest::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => bcrypt($password),
        ]);

        $this->post(
            action([SignInController::class, 'handle']),
            $request
        )->assertInvalid(['email']);

    }

}

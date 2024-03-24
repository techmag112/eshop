<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_sign_up_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertSee('E-mail')
            ->assertSee('Пароль')
            ->assertSee('Повторите пароль')
            ->assertSee('Зарегестрироваться')
            ->assertSee('Войти в аккаунт')
            ->assertViewIs('auth.sign-up');
    }

    /** @test */
    public function it_register_submit_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@test.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));

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
    public function it_register_submit_error_with_invalid_email(): void
    {

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $this->post(
            action([SignUpController::class, 'handle']),
            $request
        )->assertInvalid(['email']);

    }

    /** @test */
    public function it_register_submit_error_with_invalid_password(): void
    {

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '987654321',
        ]);

        $this->post(
            action([SignUpController::class, 'handle']),
            $request
        )->assertInvalid(['password']);

    }

}

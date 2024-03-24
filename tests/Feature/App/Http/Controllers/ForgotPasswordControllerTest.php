<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertSee('E-mail')
            ->assertSee('Отправить')
            ->assertSee('Вспомнил пароль')
            ->assertViewIs('auth.forgot-password');
    }

}

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Services\TwilioService;
use Livewire\Volt\Volt;
use Livewire\Livewire;
use Mockery;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertSeeVolt('pages.auth.register');
});

test('new users can register by verifying their phone number', function () {
    // 1. Mock Twilio send verification code
    $twilioMock = Mockery::mock(TwilioService::class);
    $twilioMock->shouldReceive('sendVerificationCode')
        ->once()
        ->with('+971501234567')
        ->andReturn(true);
    
    // Bind to container
    $this->app->instance(TwilioService::class, $twilioMock);

    // 2. Submit the registration form
    $registerComponent = Volt::test('pages.auth.register')
        ->set('firstName', 'Test')
        ->set('lastName', 'User')
        ->set('email', 'test@example.com')
        ->set('phone', '+971501234567')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $registerComponent->call('register')
        ->assertHasNoErrors()
        ->assertDispatched('open-verify-modal');

    // 3. Mock Twilio check verification code
    $twilioMock->shouldReceive('checkVerificationCode')
        ->once()
        ->with('+971501234567', '123456')
        ->andReturn(true);

    // 4. Test the verification modal component
    $verifyComponent = Livewire::test(\App\Livewire\VerifyPhoneModal::class)
        ->set('code', '123456')
        ->call('verifyCode');

    // 5. Assert redirection and authentication
    $verifyComponent->assertRedirect(route('filament.account.pages.dashboard', absolute: false));
    $this->assertAuthenticated();
});

<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class VerifyPhoneModal extends Component
{
    public bool $showModal = false;
    public string $code = '';
    public ?string $error = null;
    public ?int $expiresAt = null;
    public bool $canResend = false;

    #[On('open-verify-modal')]
    public function openModal()
    {
        $this->reset(['code', 'error']);

        // Check if we're in a cooldown period
        $cooldownUntil = session('resend_cooldown_until');
        if ($cooldownUntil && now()->lessThan($cooldownUntil)) {
            $this->expiresAt = $cooldownUntil->timestamp;
        } else {
            $this->expiresAt = session('code_expires_at') ? session('code_expires_at')->timestamp : null;
        }

        $this->canResend = $this->checkIfCanResend();
        $this->showModal = true;
    }

    public function verifyCode()
    {
        $this->validate(['code' => 'required|digits:6']);

        // Retrieve all necessary data from the session
        $correctCode = session('verification_code');
        $expiresAt = session('code_expires_at');
        $attempts = session('verify_attempts', 0);

        // Security Check 1: Session expired or tampered with
        if (!$correctCode || !$expiresAt) {
            $this->error = 'Your verification session has expired. Please try registering again.';
            return;
        }

        // Security Check 2: Code has expired (server-side check)
        if (now()->greaterThan($expiresAt)) {
            $this->error = 'Your verification code has expired. Please request a new one.';
            return;
        }

        // Security Check 3: Too many attempts
        if ($attempts >= 3) {
            $this->error = 'You have exceeded the maximum number of attempts. Please request a new code.';
            return;
        }

        // Check if the code is incorrect
        $phone = session('registration_data.phone');
        $verified = app(TwilioService::class)->checkVerificationCode($phone, $this->code);

        if (!$verified) {
            // Increment attempts
            session(['verify_attempts' => $attempts + 1]);

            $remainingAttempts = 3 - ($attempts + 1);
            if ($remainingAttempts > 0) {
                $this->error = "Invalid verification code. You have {$remainingAttempts} " . ($remainingAttempts === 1 ? 'attempt' : 'attempts') . " remaining.";
            } else {
                $this->error = 'You have exceeded the maximum number of attempts. Please request a new code.';
            }
            return;
        }

        // --- Verification Successful: Now we create the user ---
        $userData = session('registration_data');
        if (!$userData) {
            $this->error = 'Could not find your registration data. Please start over.';
            return;
        }

        // Create the user from the session data
        $user = User::create($userData);
        $user->forceFill(['phone_verified_at' => now()])->save();

        // Assign the correct role
        if ($user->type === 'client') {
            $user->assignRole('client');
        } else {
            $user->assignRole($user->type);
        }

        // Clean up all the temporary session data
        session()->forget([
            'registration_data',
            'verification_code',
            'code_expires_at',
            'verify_attempts',
            'resend_attempts',
            'resend_cooldown_until'
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirect to the dashboard
        return redirect()->route('filament.account.pages.dashboard');
    }

    public function resendCode()
    {
        // Check cooldown period
        $cooldownUntil = session('resend_cooldown_until');
        if ($cooldownUntil && now()->lessThan($cooldownUntil)) {
            $remainingSeconds = now()->diffInSeconds($cooldownUntil, false);
            $this->error = "Please wait {$remainingSeconds} seconds before requesting a new code.";
            return;
        }

        $phone = session('registration_data.phone');

        if (!$phone) {
            $this->error = 'Could not find your phone number to resend the code. Please start over.';
            return;
        }

        // Use Twilio Verify API instead of direct SMS
        $success = app(TwilioService::class)->sendVerificationCode($phone);

        if (!$success) {
            $this->error = 'Failed to send verification code. Please try again.';
            return;
        }

        // Increment resend attempts and calculate cooldown
        $resendAttempts = session('resend_attempts', 0) + 1;
        $cooldownSeconds = $this->calculateCooldown($resendAttempts);

        // Reset the session values for the new code
        session([
            'code_expires_at' => now()->addSeconds(60),
            'verify_attempts' => 0,
            'resend_attempts' => $resendAttempts,
            'resend_cooldown_until' => now()->addSeconds($cooldownSeconds),
        ]);

        // Update the countdown timer on the front-end
        $this->expiresAt = now()->addSeconds(60)->timestamp;
        $this->canResend = false;
        $this->reset('error');
        session()->flash('status', 'A new verification code has been sent.');

        // Dispatch event to restart countdown
        $this->dispatch('code-resent');
    }

    private function calculateCooldown(int $attempts): int
    {
        return match($attempts) {
            1, 2, 3 => 0,        // No cooldown for first 3 attempts
            4, 5 => 300,         // 5 minutes for attempts 4-5
            6, 7 => 900,         // 15 minutes for attempts 6-7
            default => 3600,     // 1 hour for 8+ attempts
        };
    }

    private function checkIfCanResend(): bool
    {
        $cooldownUntil = session('resend_cooldown_until');
        $codeExpiresAt = session('code_expires_at');

        // Can resend if no cooldown AND code is expired
        return (!$cooldownUntil || now()->greaterThan($cooldownUntil)) &&
            (!$codeExpiresAt || now()->greaterThan($codeExpiresAt));
    }

    public function closeModal()
    {
        // Allow user to close the modal and start over
        session()->forget([
            'registration_data',
            'verification_code',
            'code_expires_at',
            'verify_attempts',
            'resend_attempts',
            'resend_cooldown_until'
        ]);
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.verify-phone-modal');
    }
}

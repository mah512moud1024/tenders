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

    #[On('open-verify-modal')]
    public function openModal()
    {
        $this->reset(['code', 'error']);
        // Set the expiry timestamp for the countdown timer in the view
        $this->expiresAt = session('code_expires_at') ? session('code_expires_at')->timestamp : null;
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
            $this->error = 'Invalid verification code. Please try again.';
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
        session()->forget(['registration_data', 'verification_code', 'code_expires_at', 'verify_attempts']);

        event(new Registered($user));
        Auth::login($user);

        // Redirect to the dashboard
        return redirect()->route('filament.account.pages.dashboard');
    }

    public function resendCode()
    {
        $newCode = random_int(100000, 999999);
        $phone = session('registration_data.phone');

        if (!$phone) {
            $this->error = 'Could not find your phone number to resend the code. Please start over.';
            return;
        }

        $message = "Your new verification code is: {$newCode}";
        app(TwilioService::class)->sendSms($phone, $message);

        // Reset the session values for the new code
        session([
            'verification_code' => $newCode,
            'code_expires_at' => now()->addSeconds(60),
            'verify_attempts' => 0,
        ]);

        // Update the countdown timer on the front-end
        $this->expiresAt = now()->addSeconds(60)->timestamp;
        $this->reset('error');
        session()->flash('status', 'A new verification code has been sent.');
    }

    public function closeModal()
    {
        // Allow user to close the modal and start over
        session()->forget(['registration_data', 'verification_code', 'code_expires_at', 'verify_attempts']);
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.verify-phone-modal');
    }
}

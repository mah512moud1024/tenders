<?php

use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Password;
use App\Services\TwilioService;
new #[Layout('components.public-layout')] class extends Component
{
    use WithFileUploads;

    // Overall form state
    public string $userType = 'client'; // 'client' or 'business'

    // Properties for both forms
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Properties specific to business owners
    public string $businessType = 'consultant'; // Default business type
    public string $businessName = '';
    public string $businessNameEn = '';
    public string $officeAddress = '';
    public $tradingLicense; // File upload
    public string $licenseExpiry = '';
    public $city_id = '';
    public $cities = [];

    public function mount()
    {
        $this->cities = City::where('active', true)->get();
    }

    /**
     * Define the validation rules.
     */
    protected function rules()
    {
        $rules = [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ];

        if ($this->userType === 'business') {
            $rules = array_merge($rules, [
                'businessType' => ['required', 'in:consultant,contractor,subcontractor,supplier'],
                'businessName' => ['required', 'string', 'max:255'],
                'businessNameEn' => ['nullable', 'string', 'max:255'],
                'officeAddress' => ['required', 'string'],
                'licenseExpiry' => ['required', 'date'],
                'tradingLicense' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // 10MB Max
                'city_id' => ['required', 'exists:cities,id'],
            ]);
        }

        return $rules;
    }

    /**
     * Handle the registration form submission.
     */
    public function register(): void
    {
        $validated = $this->validate();
        $verificationCode = random_int(100000, 999999);
        $message = "Your verification code is: {$verificationCode}";

        // Use the Twilio Service to send the SMS  $smsSent = app(TwilioService::class)->sendSms($this->phone, $message);


        $smsSent = app(TwilioService::class)->sendVerificationCode($this->phone);
        if (!$smsSent) {
            $this->addError('phone', 'We could not send a verification code to this number. Please check it and try again.');
            return;
        }

        $userData = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'type' => $this->userType === 'client' ? 'client' : $this->businessType,
            'phone_verify_code' => $verificationCode,
        ];

        if ($this->userType === 'business') {
            $licensePath = $this->tradingLicense->store('licenses', 'public');
            $userData = array_merge($userData, [
                'business_name' => $this->businessName,
                'business_name_en' => $this->businessNameEn,
                'office_address' => $this->officeAddress,
                'license_expiry' => $this->licenseExpiry,
                'trading_license' => $licensePath,
                'city_id' => $this->city_id, // Add city_id
                'approved' => false, // Businesses need approval
            ]);
        } else {
            $userData['approved'] = true; // Clients are auto-approved
        }
        session([
            'registration_data' => $userData,
            'verification_code' => $verificationCode,
            'code_expires_at' => now()->addSeconds(60),
            'verify_attempts' => 0,
        ]);

        $this->dispatch('open-verify-modal');

    }
}; ?>

<div>
    <!-- Hero Section for Registration -->
    <section class="bg-[#f3f3f3] pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden">
        <div style="
            background-image: url('{{ asset('bg-top-lines.svg') }}');
            background-repeat: no-repeat;
            background-position: top left;
            background-size: cover;">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        {{__('Join Our')}} <span class="text-indigo-600">{{__('Platform')}}</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                        {{__('Create your account and start connecting with trusted construction partners in the UAE')}}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="section-padding bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Registration Form -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100" >
                    <form wire:submit="register" class="space-y-6">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ __('Create Your Account') }}</h2>
                        </div>

                        <!-- User Type Selector -->
                        <div class="grid grid-cols-2 gap-4 p-2 bg-gray-100 rounded-lg" wire:loading.class="opacity-50">
                            <button type="button"
                                    wire:click="$set('userType', 'client')"
                                    wire:loading.attr="disabled"
                                    class="px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2 @if($userType === 'client') bg-white text-gray-800 shadow-lg transform -translate-y-1 @else text-gray-600 hover:text-gray-800 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Client') }}
                            </button>
                            <button type="button"
                                    wire:click="$set('userType', 'business')"
                                    wire:loading.attr="disabled"
                                    class="px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2 @if($userType === 'business') bg-white text-gray-800 shadow-lg transform -translate-y-1 @else text-gray-600 hover:text-gray-800 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                </svg>
                                {{ __('company') }}
                            </button>
                        </div>

                        <!-- Shared Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="firstName" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('First Name') }}
                                </label>
                                <x-text-input wire:model="firstName" id="firstName" name="firstName" type="text" class="block w-full mt-1" required autofocus autocomplete="given-name" />
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>
                            <div class="space-y-2">
                                <label for="lastName" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Last Name') }}
                                </label>
                                <x-text-input wire:model="lastName" id="lastName" name="lastName" type="text" class="block w-full mt-1" required autocomplete="family-name" />
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                {{ __('Email') }}
                            </label>
                            <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full mt-1" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                {{ __('Phone Number') }}
                            </label>
                            <x-text-input wire:model="phone" id="phone" name="phone" type="tel" class="block w-full mt-1" required autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Business-Only Fields -->
                        @if ($userType === 'business')
                            <div class="pt-6 mt-6 border-t border-gray-200 space-y-6" wire:key="business-fields">
                                <!-- Add this city selection field -->
                                <div class="space-y-2">
                                    <label for="city_id" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('City') }}
                                    </label>
                                    <select wire:model="city_id" id="city_id" name="city_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">{{ __('Select City') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                                </div>

                                <!-- Rest of existing business fields... -->
                                <div class="space-y-2">
                                    <label for="businessType" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Business Type') }}
                                    </label>
                                    <select wire:model="businessType" id="businessType" name="businessType" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="consultant">{{ __('Consultant') }}</option>
                                        <option value="contractor">{{ __('Contractor') }}</option>
                                        <option value="subcontractor">{{ __('Subcontractor') }}</option>
                                        <option value="supplier">{{ __('Supplier') }}</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('businessType')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div class="space-y-2">
                                        <x-input-label for="businessName" :value="__('Business Name (Arabic)')" />
                                        <x-text-input wire:model="businessName" id="businessName" name="businessName" type="text" class="block w-full mt-1" />
                                        <x-input-error :messages="$errors->get('businessName')" class="mt-2" />
                                    </div>
                                    <div class="space-y-2">
                                        <x-input-label for="businessNameEn" :value="__('Business Name (English)')" />
                                        <x-text-input wire:model="businessNameEn" id="businessNameEn" name="businessNameEn" type="text" class="block w-full mt-1" />
                                        <x-input-error :messages="$errors->get('businessNameEn')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="officeAddress" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Office Address') }}
                                    </label>
                                    <x-text-input wire:model="officeAddress" id="officeAddress" name="officeAddress" type="text" class="block w-full mt-1" />
                                    <x-input-error :messages="$errors->get('officeAddress')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <label for="licenseExpiry" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('License Expiry Date') }}
                                    </label>
                                    <x-text-input wire:model="licenseExpiry" id="licenseExpiry" name="licenseExpiry" type="date" class="block w-full mt-1" />
                                    <x-input-error :messages="$errors->get('licenseExpiry')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <label for="tradingLicense" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Trading License') }}
                                    </label>
                                    <input wire:model="tradingLicense" id="tradingLicense" name="tradingLicense" type="file" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <div wire:loading wire:target="tradingLicense" class="mt-2 text-sm text-gray-500">{{ __('Uploading...') }}</div>
                                    <x-input-error :messages="$errors->get('tradingLicense')" class="mt-2" />
                                </div>
                            </div>
                        @endif

                        <!-- Password Fields -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Password') }}
                                </label>
                                <x-text-input wire:model="password" id="password" name="password" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Confirm Password') }}
                                </label>
                                <x-text-input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center gap-2"
                               href="{{ route('login') }}" wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Already registered?') }}
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all transform hover:-translate-y-1"
                                    wire:loading.attr="disabled"
                                    wire:target="register">
                                <span wire:loading.remove wire:target="register">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="register">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span wire:loading.remove wire:target="register">
                                    {{ __('Register') }}
                                </span>
                                <span wire:loading wire:target="register">
                                    {{ __('Processing...') }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Benefits Sidebar -->
                <div class="space-y-6" >
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 p-8 rounded-2xl text-white">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold mb-4">{{__('Why Join Our Platform?')}}</h3>
                            <div class="text-5xl font-bold mb-2">1000+</div>
                            <p class="text-indigo-100 mb-6">{{__('Active Companies')}}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ([
                            ['icon' => '✓', 'title' => 'Find Trusted Partners', 'text' => 'Connect with verified contractors and consultants'],
                            ['icon' => '⚡', 'title' => 'Fast & Efficient', 'text' => 'Streamline your bidding process'],
                            ['icon' => '💰', 'title' => 'Save Time & Money', 'text' => 'Get competitive quotes quickly'],
                            ['icon' => '🛡️', 'title' => 'Secure Platform', 'text' => 'Your data and projects are protected']
                        ] as $benefit)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <span class="text-indigo-600 font-bold">{{ $benefit['icon'] }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{__($benefit['title'])  }}</h4>
                                    <p class="text-gray-600">{{__($benefit['text'] ) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                {{__('Ready to Get Started?')}}
            </h2>
            <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                {{__('Join thousands of companies already using our platform to find the perfect partners for their projects.?')}}
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
                    {{__('Sign In to Your Account')}}
                </a>
                <a href="#home" class="inline-flex items-center justify-center bg-transparent border border-white text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors">
                    {{__('Learn More')}}
                </a>
            </div>
        </div>
    </section>
</div>


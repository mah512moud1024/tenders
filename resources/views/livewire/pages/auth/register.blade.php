<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Password;

new #[Layout('layouts.guest')] class extends Component
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

        $userData = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'type' => $this->userType === 'client' ? 'client' : $this->businessType,
        ];

        if ($this->userType === 'business') {
            $licensePath = $this->tradingLicense->store('licenses', 'public');
            $userData = array_merge($userData, [
                'business_name' => $this->businessName,
                'business_name_en' => $this->businessNameEn,
                'office_address' => $this->officeAddress,
                'license_expiry' => $this->licenseExpiry,
                'trading_license' => $licensePath,
                'approved' => false, // Businesses need approval
            ]);
        } else {
            $userData['approved'] = true; // Clients are auto-approved
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>


<div>
    <form wire:submit="register" class="space-y-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">{{ __('Create Your Account') }}</h2>

        <!-- User Type Selector -->
        <div class="grid grid-cols-2 gap-4 p-1 bg-gray-100 rounded-lg dark:bg-gray-700">
            <button type="button"
                    wire:click="$set('userType', 'client')"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
                    :class="{ 'bg-white text-gray-800 shadow': '{{ $userType }}' === 'client', 'text-gray-600 dark:text-gray-300': '{{ $userType }}' !== 'client' }">
                {{ __('I am a Client') }}
            </button>
            <button type="button"
                    wire:click="$set('userType', 'business')"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
                    :class="{ 'bg-white text-gray-800 shadow': '{{ $userType }}' === 'business', 'text-gray-600 dark:text-gray-300': '{{ $userType }}' !== 'business' }">
                {{ __('I am a Business Owner') }}
            </button>
        </div>

        <!-- Shared Fields -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="firstName" :value="__('First Name')" />
                <x-text-input wire:model="firstName" id="firstName" name="firstName" type="text" class="block w-full mt-1" required autofocus autocomplete="given-name" />
                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="lastName" :value="__('Last Name')" />
                <x-text-input wire:model="lastName" id="lastName" name="lastName" type="text" class="block w-full mt-1" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full mt-1" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input wire:model="phone" id="phone" name="phone" type="tel" class="block w-full mt-1" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Business-Only Fields -->
        @if ($userType === 'business')
            <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-600 space-y-6">
                <div>
                    <x-input-label for="businessType" :value="__('Business Type')" />
                    <select wire:model="businessType" id="businessType" name="businessType" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="consultant">{{ __('Consultant') }}</option>
                        <option value="contractor">{{ __('Contractor') }}</option>
                        <option value="subcontractor">{{ __('Subcontractor') }}</option>
                        <option value="supplier">{{ __('Supplier') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('businessType')" class="mt-2" />
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <x-input-label for="businessName" :value="__('Business Name (Arabic)')" />
                        <x-text-input wire:model="businessName" id="businessName" name="businessName" type="text" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('businessName')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="businessNameEn" :value="__('Business Name (English)')" />
                        <x-text-input wire:model="businessNameEn" id="businessNameEn" name="businessNameEn" type="text" class="block w-full mt-1" />
                        <x-input-error :messages="$errors->get('businessNameEn')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="officeAddress" :value="__('Office Address')" />
                    <x-text-input wire:model="officeAddress" id="officeAddress" name="officeAddress" type="text" class="block w-full mt-1" />
                    <x-input-error :messages="$errors->get('officeAddress')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="licenseExpiry" :value="__('License Expiry Date')" />
                    <x-text-input wire:model="licenseExpiry" id="licenseExpiry" name="licenseExpiry" type="date" class="block w-full mt-1" />
                    <x-input-error :messages="$errors->get('licenseExpiry')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tradingLicense" :value="__('Trading License (PDF or Image)')" />
                    <input wire:model="tradingLicense" id="tradingLicense" name="tradingLicense" type="file" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <div wire:loading wire:target="tradingLicense" class="mt-2 text-sm text-gray-500">{{ __('Uploading...') }}</div>
                    <x-input-error :messages="$errors->get('tradingLicense')" class="mt-2" />

                    @if ($tradingLicense && !$errors->has('tradingLicense'))
                        <div class="mt-4">
                            @if(method_exists($tradingLicense, 'temporaryUrl'))
                                @if (in_array($tradingLicense->guessExtension(), ['png', 'jpg', 'jpeg']))
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('Image Preview:') }}</p>
                                    <img src="{{ $tradingLicense->temporaryUrl() }}" class="mt-2 h-32 rounded-lg border">
                                @else
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('File Ready:') }} {{ $tradingLicense->getClientOriginalName() }}</p>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        @endif


        <!-- Password Fields -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="password" id="password" name="password" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4" wire:loading.attr="disabled" wire:target="register">
                 <span wire:loading.remove wire:target="register">
                    {{ __('Register') }}
                </span>
                <span wire:loading wire:target="register">
                    {{ __('Processing...') }}
                </span>
            </x-primary-button>
        </div>
    </form>
</div>


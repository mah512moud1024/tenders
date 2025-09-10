<?php

namespace App\Filament\Account\Pages;

use Filament\Panel;

use Filament\Forms\Components\Form;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Actions\Action;



use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Registration extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.account.pages.registration';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];
    public $success = false;

    public function mount(): void
    {
        if (auth()->check()) {
            redirect('/');
        }


    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Account Type')
                        ->schema([
                            Section::make('Select Account Type')
                                ->description('Choose the type of account you want to create')
                                ->schema([
                                    ToggleButtons::make('account_type')
                                        ->label('')
                                        ->options([
                                            'client' => 'Client',
                                            'business' => 'Business Owner',
                                        ])
                                        ->default('client')
                                        ->required()
                                        ->inline()
                                        ->grouped(),
                                ]),
                        ]),
                    Step::make('Personal Information')
                        ->schema([
                            Section::make('Personal Details')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->label('First Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('last_name')
                                        ->label('Last Name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('phone')
                                        ->label('Phone Number')
                                        ->required()
                                        ->tel()
                                        ->unique('users', 'phone')
                                        ->maxLength(255),
                                    TextInput::make('email')
                                        ->label('Email Address')
                                        ->required()
                                        ->email()
                                        ->unique('users', 'email')
                                        ->maxLength(255),
                                ])
                                ->columns(2),
                        ]),
                    Step::make('Security')
                        ->schema([
                            Section::make('Account Security')
                                ->schema([
                                    TextInput::make('password')
                                        ->label('Password')
                                        ->required()
                                        ->password()
                                        ->rules([Password::min(8)->letters()->mixedCase()->numbers()])
                                        ->confirmed(),
                                    TextInput::make('password_confirmation')
                                        ->label('Confirm Password')
                                        ->required()
                                        ->password(),
                                ])
                                ->columns(2),
                        ]),
                    Step::make('Business Information')
                        ->schema([
                            Section::make('Business Details')
                                ->description('Required for business accounts')
                                ->schema([
                                    Select::make('business_type')
                                        ->label('Business Type')
                                        ->options([
                                            'consultant' => 'Consultant',
                                            'contractor' => 'Contractor',
                                            'supplier' => 'Supplier',
                                            'subcontractor' => 'Subcontractor',
                                        ])
                                        ->required()
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                    TextInput::make('business_name')
                                        ->label('Business Name')
                                        ->required()
                                        ->maxLength(255)
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                    TextInput::make('business_name_en')
                                        ->label('Business Name (English)')
                                        ->required()
                                        ->maxLength(255)
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                    TextInput::make('office_address')
                                        ->label('Office Address')
                                        ->required()
                                        ->maxLength(500)
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                    DatePicker::make('license_expiry')
                                        ->label('License Expiry Date')
                                        ->required()
                                        ->minDate(now())
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                    FileUpload::make('trading_license')
                                        ->label('Trading License')
                                        ->required()
                                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                        ->maxSize(5120)
                                        ->directory('licenses')
                                        ->visibility('private')
                                        ->visible(fn ($get) => $get('account_type') === 'business'),
                                ])
                                ->visible(fn ($get) => $get('account_type') === 'business'),
                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="lg"
                        class="w-full"
                    >
                        Complete Registration
                    </x-filament::button>
                BLADE)))
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        try {
            if ($data['account_type'] === 'client') {
                $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'type' => 'client',
                    'approved' => true,
                ]);

                $user->assignRole('client');
            } else {
                $licensePath = $data['trading_license'];

                $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'type' => $data['business_type'],
                    'business_name' => $data['business_name'],
                    'business_name_en' => $data['business_name_en'],
                    'office_address' => $data['office_address'],
                    'trading_license' => $licensePath,
                    'license_expiry' => $data['license_expiry'],
                    'approved' => false,
                ]);

                $user->assignRole($data['business_type']);
            }

            auth()->login($user);
            $this->success = true;

            Notification::make()
                ->title('Registration Successful')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Registration Failed')
                ->body('An error occurred during registration. Please try again.')
                ->danger()
                ->send();
        }
    }

    public static function getRouteName(?Panel $panel = null): string
    {
        return static::generateRouteName('registration', $panel);
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return 'registration';
    }
}

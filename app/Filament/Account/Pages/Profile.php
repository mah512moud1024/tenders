<?php

namespace App\Filament\Account\Pages;

use App\Models\City;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Form;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;

class Profile extends Page
{

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected  string $view = 'filament.account.pages.profile';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $title = 'Profile Settings';
    protected static ?int $navigationSort = 10;

    public ?array $data = [];
    public User $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->form->fill([
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,

        ]);
    }

    public function form(Schema  $Schema ): Schema
    {
        $isBusinessUser = in_array($this->user->type, ['consultant', 'contractor', 'subcontractor', 'supplier']);

        return $Schema
            ->schema([
                // 🔥 FEATURE: Apply disabled to all form fields by default, except exceptions
                Component::configureUsing(function (Component $component) {
                    if (method_exists($component, 'getName')) {
                        // Only disable fields that are NOT on the allowed edit list
                        if (!in_array($component->getName(), ['email', 'new_password', 'new_password_confirmation', 'trading_license', 'license_expiry'])) {
                            // Apply disabled only to input-type fields
                            if ($component instanceof TextInput || $component instanceof Select || $component instanceof DatePicker) {
                                $component->disabled();
                                $component->dehydrated(true);
                            }
                        }
                    }
                }),
                Section::make('Personal Information')
                    ->description('Most of your personal details are locked for security. Only your email is editable.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20),
                            ]),
                    ])
                    ->columns(1),

//                $isBusinessUser ? Section::make('Business Information')
//                    ->description('These details are read-only and require administrator approval to change. You can update your Trading License file and expiry date.')
//                    ->schema([
//
//                                TextInput::make('business_name')
//                                    ->label('Business Name (Arabic)')
//                                    ->maxLength(255),
//                                TextInput::make('business_name_en')
//                                    ->label('Business Name (English)')
//                                    ->maxLength(255),
//
//                        TextInput::make('office_address')
//                            ->label('Office Address')
//                            ->maxLength(500),
//                        Select::make('city_id')
//                            ->label('City')
//                            ->options(City::where('active', true)->pluck('name', 'id'))
//                            ->searchable()
//                            ->required(),
//                        // license_expiry is allowed to be edited
//                        DatePicker::make('license_expiry')
//                            ->label('License Expiry Date')
//                            ->required(),
//                        // trading_license is allowed to be edited
//                        FileUpload::make('trading_license')
//                            ->label('Trading License')
//                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
//                            ->maxSize(10240)
//                            ->directory('licenses')
//                            ->downloadable()
//                            ->helperText('Upload your trading license (PDF, JPEG, PNG) - Max 10MB')
//                    ])
//                    ->columns(3) : null,

                Section::make('Change Password')
                    ->description('Update your password by filling in the fields below. Current password is not required.')
                    ->schema([
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation, ?array $state = []): bool => filled(($state ?? [])['new_password_confirmation'] ?? []))

                            ->rules(['min:8', 'confirmed']),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->revealable()
                    ->required(fn (string $operation, ?array $state = []): bool => filled(($state ?? [])['new_password'] ?? [])),

                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save')
                ->color('primary'),
        ];

    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Update basic information
            $this->user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],

            ]);

            // Handle password change
            if ( !empty($data['new_password'])) {
                $this->user->update([
                    'password' => Hash::make($data['new_password']),
                ]);
            }

            // Handle file upload
            if (isset($data['trading_license']) && $data['trading_license']) {
                $this->user->update([
                    'trading_license' => $data['trading_license'],
                ]);
            }

            Notification::make()
                ->title('Profile Updated')
                ->body('Your profile has been successfully updated.')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('There was an error updating your profile: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }
}

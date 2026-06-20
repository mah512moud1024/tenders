<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\NewServiceProviderAdminNotification;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable implements FilamentUser

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setNameAttribute($value): void
    {
        $parts = explode(' ', (string) $value, 2);
        $this->first_name = $parts[0] ?? '';
        $this->last_name = $parts[1] ?? '';
    }


    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->hasRole('admin');
        }

        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'type',
        'business_name',
        'business_name_en',
        'office_address',
        'trading_license',
        'license_expiry',
        'approved',
        'phone_verified_at',
        'phone_verify_code',
        'city_id',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            // Notify admin when service providers register
            $serviceProviderTypes = ['consultant', 'contractor', 'subcontractor', 'supplier'];

            if (in_array($user->type, $serviceProviderTypes)) {
                $admins = User::whereHas('roles', function ($query) {
                    $query->where('name', 'admin');
                })->get();

                foreach ($admins as $admin) {
                    $admin->notify(new NewServiceProviderAdminNotification($user));
                }
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone_verify_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'license_expiry' => 'datetime',
            'approved' => 'boolean',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
        ];
    }
    public function serviceAreas()
    {
        return $this->hasMany(ServiceArea::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    /**
     * Get all admin users
     */
    public static function getAdmins()
    {
        return static::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function contractsAsClient()
    {
        return $this->hasMany(Contract::class, 'client_id');
    }

    public function contractsAsProvider()
    {
        return $this->hasMany(Contract::class, 'provider_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getServiceCitiesAttribute()
    {
        return $this->serviceAreas->map(function($area) {
            return $area->city;
        });
    }


    /**
     * Check if the user has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->exists();
    }

    /**
     * Check if the user is allowed to submit a new quote.
     */
    public function canSubmitQuote(): bool
    {
        // If they have an active subscription, they can always submit.
        if ($this->hasActiveSubscription()) {
            return true;
        }

        // Otherwise, check if they have submitted less than 2 quotes.
        return $this->quotes()->count() < 2;
    }

}

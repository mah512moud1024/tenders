<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
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
}

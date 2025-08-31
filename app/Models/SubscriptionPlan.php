<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'interval',
        'free_quotes',
        'listing_limit',
        'featured_listing',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'free_quotes' => 'integer',
        'listing_limit' => 'integer',
        'featured_listing' => 'boolean',
        'active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}

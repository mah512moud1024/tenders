<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'user_id',
        'amount',
        'proposal',
        'status',
        'selected'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'selected' => 'boolean',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(QuoteDocument::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}

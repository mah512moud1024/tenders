<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'quote_id',
        'client_id',
        'provider_id',
        'contract_number',
        'terms',
        'agreed_amount',
        'start_date',
        'end_date',
        'status',
        'signed_contract_file'
    ];

    protected $casts = [
        'agreed_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}

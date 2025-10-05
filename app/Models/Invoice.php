<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'transaction_id',
        'user_id',
        'issue_date',
        'due_date',
        'amount',
        'tax_amount',
        'total_amount',
        'status',
        'notes',
        'invoiceable_type',
        'invoiceable_id',
        'commission_rate',
        'quote_total_value',
        'currency',
        'payment_terms'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'quote_total_value' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Add the polymorphic relationship
    public function invoiceable()
    {
        return $this->morphTo();
    }

    // Helper method to check if it's a commission invoice
    public function isCommission()
    {
        return !is_null($this->commission_rate) && !is_null($this->quote_total_value);
    }

    // Helper method to check if invoice is unpaid
    public function isUnpaid()
    {
        return is_null($this->transaction_id) && in_array($this->status, ['draft', 'sent']);
    }
}

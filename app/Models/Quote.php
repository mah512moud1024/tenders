<?php

namespace App\Models;

use App\Notifications\NewQuoteAdminNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\QuoteStatusChangedNotification;
use App\Notifications\NewQuoteReceivedNotification;
use App\Notifications\QuoteAcceptedToSubmitterNotification;
use App\Notifications\QuoteAcceptedToTenderOwnerNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;




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
    protected static function booted()
    {


        static::created(function ($quote) {


            $admins = User::role('admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(new NewQuoteAdminNotification($quote, $quote->tender, $quote->user));
            }
        });

        static::updated(function ($quote) {
            // Only notify for these specific statuses
            if ($quote->status === 'submitted' ) {
            // Notify the tender owner that they received a new quote
            $tenderOwner = $quote->tender->user;
            $tenderOwner->notify(new NewQuoteReceivedNotification($quote, $quote->tender));
            }});

        static::updated(function ($quote) {
            // Check if status was changed
            if ($quote->isDirty('status')) {
                $oldStatus = $quote->getOriginal('status');
                $newStatus = $quote->status;

                // Notify the user who submitted the quote
                $quote->user->notify(new QuoteStatusChangedNotification($quote, $oldStatus, $newStatus));
            }

            // If quote is accepted, exchange contact information
            if ($newStatus === 'accepted') {
                $tenderOwner = $quote->tender->user;
                $quoteSubmitter = $quote->user;

                // Notify quote submitter with tender owner's contact info
                $quoteSubmitter->notify(new QuoteAcceptedToSubmitterNotification($quote, $quote->tender, $tenderOwner));

                // Notify tender owner with quote submitter's contact info
                $tenderOwner->notify(new QuoteAcceptedToTenderOwnerNotification($quote, $quote->tender, $quoteSubmitter));
            }

        });
    }

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

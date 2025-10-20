<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Models\Tender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewQuoteReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quote $quote,
        public Tender $tender
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Quote Received for Your Tender: ' . $this->tender->title)
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('You have received a new quote for your tender:')
            ->line('**Tender:** ' . $this->tender->title)
            ->line('**Quote Amount:** SAR ' . number_format($this->quote->amount, 2))
            ->line('**Submitted by:** ' . $this->quote->user->business_name ?? $this->quote->user->full_name)
            ->line('**Proposal:** ' . Str::limit($this->quote->proposal, 100))
            ->action('View Quote Details', $this->getQuoteUrl())
            ->line('You can review this quote and update its status in your dashboard.')
            ->line('Thank you for using our platform!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'tender_id' => $this->tender->id,
            'tender_title' => $this->tender->title,
            'quote_amount' => $this->quote->amount,
            'submitter_name' => $this->quote->user->business_name ?? $this->quote->user->full_name,
            'message' => 'New quote received for your tender: ' . $this->tender->title,
        ];
    }

    protected function getQuoteUrl(): string
    {
        // Adjust this URL based on your Filament panel structure
        if (config('filament.auth.guard')) {
            return route('filament.admin.resources.quotes.view', $this->quote);
        }

        return url('/quotes/' . $this->quote->id);
    }
}

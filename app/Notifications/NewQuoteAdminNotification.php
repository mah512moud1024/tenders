<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuoteAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quote $quote,
        public Tender $tender,
        public User $submitter
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('💰 New Quote Submitted: ' . $this->tender->title)
            ->greeting('Hello Admin!')
            ->line('A new quote has been submitted on the platform:')
            ->line('')
            ->line('**Quote Details:**')
            ->line('**Tender:** ' . $this->tender->title)
            ->line('**Amount:** SAR ' . number_format($this->quote->amount, 2))
            ->line('**Status:** ' . ucfirst($this->quote->status))
            ->line('**Submitted:** ' . $this->quote->created_at->format('M d, Y H:i'))
            ->line('')
            ->line('**Service Provider Information:**')
            ->line('**Company:** ' . ($this->submitter->business_name ?? 'N/A'))
            ->line('**Contact:** ' . $this->submitter->full_name)
            ->line('**Email:** ' . $this->submitter->email)
            ->line('**Phone:** ' . $this->submitter->phone)
            ->line('**Type:** ' . ucfirst($this->submitter->type))
            ->line('')
            ->line('**Tender Client:**')
            ->line('**Company:** ' . ($this->tender->user->business_name ?? 'N/A'))
            ->line('**Contact:** ' . $this->tender->user->full_name)
            ->action('Review Quote in Admin Panel', $this->getQuoteUrl())
            ->line('Please review this quote and update its status accordingly.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'tender_id' => $this->tender->id,
            'tender_title' => $this->tender->title,
            'submitter_id' => $this->submitter->id,
            'submitter_name' => $this->submitter->full_name,
            'submitter_type' => $this->submitter->type,
            'amount' => $this->quote->amount,
            'status' => $this->quote->status,
            'message' => 'New quote submitted for tender: ' . $this->tender->title,
            'type' => 'new_quote',
        ];
    }

    protected function getQuoteUrl(): string
    {
        return route('filament.admin.resources.quotes.view', $this->quote);
    }
}

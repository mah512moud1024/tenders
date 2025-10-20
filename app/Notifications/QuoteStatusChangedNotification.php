<?php

namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quote $quote,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Quote Status Updated: ' . $this->quote->tender->title)
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('The status of your quote has been updated:')
            ->line('**Tender:** ' . $this->quote->tender->title)
            ->line('**Quote Amount:** SAR ' . number_format($this->quote->amount, 2))
            ->line('**Previous Status:** ' . ucfirst(str_replace('_', ' ', $this->oldStatus)))
            ->line('**Current Status:** ' . ucfirst(str_replace('_', ' ', $this->newStatus)));

        // Custom message based on status (removed accepted details)
        if ($this->newStatus === 'accepted') {
            $mailMessage->line('🎉 **Congratulations! Your quote has been accepted!**')
                ->line('You will receive a separate email with the client\'s contact information shortly.');
        } elseif ($this->newStatus === 'rejected') {
            $mailMessage->line('We regret to inform you that your quote was not selected for this project.')
                ->line('Thank you for your submission and we encourage you to apply for other tenders.');
        } elseif ($this->newStatus === 'under_review') {
            $mailMessage->line('Your quote is currently under review by the client.')
                ->line('We will notify you once a decision is made.');
        }

        $mailMessage->line('Thank you for using our platform!');

        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'tender_id' => $this->quote->tender->id,
            'tender_title' => $this->quote->tender->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'amount' => $this->quote->amount,
            'message' => 'Quote status updated to: ' . $this->newStatus . ' for tender: ' . $this->quote->tender->title,
        ];
    }
}

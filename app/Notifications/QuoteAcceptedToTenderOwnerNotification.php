<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteAcceptedToTenderOwnerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quote $quote,
        public Tender $tender,
        public User $quoteSubmitter
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Quote Accepted: ' . $this->quoteSubmitter->business_name . ' for ' . $this->tender->title)
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('You have accepted the quote from **' . ($this->quoteSubmitter->business_name ?? $this->quoteSubmitter->full_name) . '**')
            ->line('**Tender:** ' . $this->tender->title)
            ->line('**Accepted Amount:** SAR ' . number_format($this->quote->amount, 2))
            ->line('')
            ->line('## 📞 Contact Information for Service Provider:')
            ->line('**Company:** ' . ($this->quoteSubmitter->business_name ?? 'N/A'))
            ->line('**Contact Person:** ' . $this->quoteSubmitter->first_name . ' ' . $this->quoteSubmitter->last_name)
            ->line('**Email:** ' . $this->quoteSubmitter->email)
            ->line('**Phone:** ' . $this->quoteSubmitter->phone)
            ->line('**Business Type:** ' . ucfirst($this->quoteSubmitter->type))
            ->line('**Office Address:** ' . ($this->quoteSubmitter->office_address ?? 'N/A'))
            ->line('')
            ->line('You can now contact them directly to proceed with contract signing and project initiation.')
            ->action('View Contract Details', $this->getContractUrl())
            ->line('We recommend discussing the next steps and timeline for the project.')
            ->line('Thank you for using our platform!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'tender_id' => $this->tender->id,
            'tender_title' => $this->tender->title,
            'quote_submitter_name' => $this->quoteSubmitter->first_name . ' ' . $this->quoteSubmitter->last_name,
            'quote_submitter_company' => $this->quoteSubmitter->business_name,
            'quote_submitter_email' => $this->quoteSubmitter->email,
            'quote_submitter_phone' => $this->quoteSubmitter->phone,
            'quote_submitter_type' => $this->quoteSubmitter->type,
            'message' => 'You accepted quote from ' . ($this->quoteSubmitter->business_name ?? $this->quoteSubmitter->full_name),
        ];
    }

    protected function getContractUrl(): string
    {
        if ($this->quote->contract) {
            return route('filament.admin.resources.contracts.view', $this->quote->contract);
        }

        return route('filament.admin.resources.quotes.view', $this->quote);
    }
}

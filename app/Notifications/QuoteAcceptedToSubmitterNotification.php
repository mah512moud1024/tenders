<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteAcceptedToSubmitterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Quote $quote,
        public Tender $tender,
        public User $tenderOwner
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Your Quote Has Been Accepted: ' . $this->tender->title)
            ->greeting('Congratulations ' . $notifiable->first_name . '!')
            ->line('Your quote has been accepted for the tender: **' . $this->tender->title . '**')
            ->line('**Quote Amount:** SAR ' . number_format($this->quote->amount, 2))
            ->line('')
            ->line('## 📞 Contact Information for Tender Owner:')
            ->line('**Company:** ' . ($this->tenderOwner->business_name ?? 'N/A'))
            ->line('**Contact Person:** ' . $this->tenderOwner->first_name . ' ' . $this->tenderOwner->last_name)
            ->line('**Email:** ' . $this->tenderOwner->email)
            ->line('**Phone:** ' . $this->tenderOwner->phone)
            ->line('**Office Address:** ' . ($this->tenderOwner->office_address ?? 'N/A'))
            ->line('')
            ->line('You can now contact them directly to proceed with the next steps.')
            ->action('View Contract Details', $this->getContractUrl())
            ->line('Thank you for using our platform!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'tender_id' => $this->tender->id,
            'tender_title' => $this->tender->title,
            'tender_owner_name' => $this->tenderOwner->first_name . ' ' . $this->tenderOwner->last_name,
            'tender_owner_company' => $this->tenderOwner->business_name,
            'tender_owner_email' => $this->tenderOwner->email,
            'tender_owner_phone' => $this->tenderOwner->phone,
            'message' => 'Your quote was accepted for: ' . $this->tender->title,
        ];
    }

    protected function getContractUrl(): string
    {
        // Adjust based on your Filament structure
        if ($this->quote->contract) {
            return route('filament.admin.resources.contracts.view', $this->quote->contract);
        }

        return route('filament.admin.resources.quotes.view', $this->quote);
    }
}

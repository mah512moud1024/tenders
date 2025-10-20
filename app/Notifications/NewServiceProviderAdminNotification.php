<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewServiceProviderAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $serviceProviderTypes = ['consultant', 'contractor', 'subcontractor', 'supplier'];

        return (new MailMessage)
            ->subject('👤 New Service Provider Registered: ' . $this->user->business_name ?? $this->user->full_name)
            ->greeting('Hello Admin!')
            ->line('A new service provider has registered on the platform:')
            ->line('')
            ->line('**Account Details:**')
            ->line('**Company:** ' . ($this->user->business_name ?? 'N/A'))
            ->line('**Contact Person:** ' . $this->user->full_name)
            ->line('**Email:** ' . $this->user->email)
            ->line('**Phone:** ' . $this->user->phone)
            ->line('**User Type:** ' . ucfirst($this->user->type))
            ->line('**Registration Date:** ' . $this->user->created_at->format('M d, Y H:i'))
            ->line('**Email Verified:** ' . ($this->user->email_verified_at ? 'Yes' : 'No'))
            ->line('**Phone Verified:** ' . ($this->user->phone_verified_at ? 'Yes' : 'No'))
            ->line('**Account Approved:** ' . ($this->user->approved ? 'Yes' : 'No'))
            ->line('')
            ->line('**Business Information:**')
            ->line('**Office Address:** ' . ($this->user->office_address ?? 'N/A'))
            ->line('**Trading License:** ' . ($this->user->trading_license ? 'Uploaded' : 'Not Uploaded'))
            ->line('**License Expiry:** ' . ($this->user->license_expiry ? $this->user->license_expiry->format('M d, Y') : 'N/A'))
            ->action('Review User in Admin Panel', $this->getUserUrl())
            ->line('Please review this account and approve it if it meets platform requirements.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->full_name,
            'user_email' => $this->user->email,
            'user_type' => $this->user->type,
            'business_name' => $this->user->business_name,
            'approved' => $this->user->approved,
            'message' => 'New service provider registered: ' . ($this->user->business_name ?? $this->user->full_name),
            'type' => 'new_service_provider',
        ];
    }

    protected function getUserUrl(): string
    {
        return route('filament.admin.resources.users.view', $this->user);
    }
}

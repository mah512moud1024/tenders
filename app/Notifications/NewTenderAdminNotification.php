<?php

namespace App\Notifications;

use App\Models\Tender;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTenderAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Tender $tender,
        public User $client
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🚀 New Tender Created: ' . $this->tender->title)
            ->greeting('Hello Admin!')
            ->line('A new tender has been created on the platform:')
            ->line('')
            ->line('**Tender Details:**')
            ->line('**Title:** ' . $this->tender->title)
            ->line('**Client:** ' . $this->client->business_name ?? $this->client->full_name)
            ->line('**Project Type:** ' . ucfirst($this->tender->project_type))
            ->line('**Tender Type:** ' . ucfirst($this->tender->tender_type))
            ->line('**Work Type:** ' . ucfirst(str_replace('_', ' ', $this->tender->work_type)))
            ->line('**Location:** ' . $this->tender->city->name . ', ' . $this->tender->city->country->name)
            ->line('**Closing Date:** ' . $this->tender->closing_date->format('M d, Y'))
            ->line('')
            ->line('**Client Information:**')
            ->line('**Name:** ' . $this->client->full_name)
            ->line('**Email:** ' . $this->client->email)
            ->line('**Phone:** ' . $this->client->phone)
            ->line('**Business:** ' . ($this->client->business_name ?? 'N/A'))
            ->action('View Tender in Admin Panel', $this->getTenderUrl())
            ->line('Please review this tender and ensure it meets platform guidelines.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tender_id' => $this->tender->id,
            'tender_title' => $this->tender->title,
            'client_id' => $this->client->id,
            'client_name' => $this->client->full_name,
            'client_business' => $this->client->business_name,
            'message' => 'New tender created: ' . $this->tender->title,
            'type' => 'new_tender',
        ];
    }

    protected function getTenderUrl(): string
    {
        return route('filament.admin.resources.tenders.view', $this->tender);
    }
}

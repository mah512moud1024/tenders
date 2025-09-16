<?php

namespace App\Filament\Account\Resources\Subscriptions\Pages;

use App\Filament\Account\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;
}

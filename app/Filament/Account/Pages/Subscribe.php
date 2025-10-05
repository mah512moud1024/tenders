<?php

namespace App\Filament\Account\Pages;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use UnitEnum;

class Subscribe extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected string $view = 'filament.account.pages.subscribe';
    protected static string | UnitEnum | null $navigationGroup =  'Subscription';

    public function getTitle(): string
    {
        return __('Subscription Plans');
    }

    public static function canAccess(): bool
    {
        $userType = Auth::user()->type;
        return in_array($userType, ['consultant', 'contractor', 'subcontractor', 'supplier', 'admin']);
    }

    public function getViewData(): array
    {
        return [
            'plans' => SubscriptionPlan::where('active', true)->orderBy('price')->get(),
            'currentSubscription' => Auth::user()->subscriptions()->whereIn('status', ['active', 'pending'])->first(),
        ];
    }




    protected function getActions(): array

    {
        return [
            Action::make('choosePlan')
                ->label(__('Choose Plan'))
                ->button()
                ->color('primary')
                ->modalHeading('Confirm Subscription Request')
                ->modalDescription('Are you sure you want to request this subscription plan?')
                ->modalSubmitActionLabel('Yes, Request Subscription')
                // We no longer need the hidden form. We will get the data from arguments.
                ->action(function (array $arguments) {
                    $user = Auth::user();
                    $planId = $arguments['plan_id']; // <-- This now correctly reads the plan_id

                    if ($user->subscriptions()->whereIn('status', ['active', 'pending'])->exists()) {
                        Notification::make()->title('Request Failed')->body('You already have an active or pending subscription.')->danger()->send();
                        return;
                    }

                    try {
                        Subscription::create([
                            'user_id' => $user->id,
                            'plan_id' => $planId,
                            'status' => 'pending',
                            'remaining_quotes' => 0,
                            'starts_at' => now(),
                        ]);

                        Notification::make()->title('Subscription Requested')->body('Your request has been sent for approval.')->success()->send();

                        return redirect(static::getUrl());

                    } catch (Throwable $e) {
                        Notification::make()->title('An error occurred')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }

}


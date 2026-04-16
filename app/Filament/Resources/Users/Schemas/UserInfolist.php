<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Personal Information
                Section::make(__('Personal Information'))
                    ->icon('heroicon-o-user-circle')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Full Name'))
                            ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                            ->columnSpan(2)
                            ->size('Large')
                            ->weight('font-semibold'),
                        IconEntry::make('approved')
                            ->label(__('Approved'))
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        TextEntry::make('email')
                            ->label(__('Email'))
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label(__('Phone'))
                            ->icon('heroicon-o-phone')
                            ->copyable(),
                        TextEntry::make('type')
                            ->label(__('User Type'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'admin' => 'danger',
                                'client' => 'primary',
                                'consultant' => 'info',
                                'contractor' => 'warning',
                                'subcontractor' => 'gray',
                                'supplier' => 'success',
                            })
                            ->icon('heroicon-o-user'),
                    ]),

                // Business Information
                Section::make(__('Business Information'))
                    ->icon('heroicon-o-building-storefront')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('business_name')
                            ->label(__('Business Name (Arabic)'))
                            ->icon('heroicon-o-building-office')
                            ->visible(fn ($record) => !empty($record->business_name)),
                        TextEntry::make('business_name_en')
                            ->label(__('Business Name (English)'))
                            ->icon('heroicon-o-building-office')
                            ->visible(fn ($record) => !empty($record->business_name_en)),
                        TextEntry::make('city.name')
                            ->label(__('City'))
                            ->icon('heroicon-o-map-pin')
                            ->visible(fn ($record) => $record->city),
                        TextEntry::make('trading_license')
                            ->label(__('Trading License'))
                            ->icon('heroicon-o-document')
                            ->visible(fn ($record) => !empty($record->trading_license))
                            ->url(fn ($record) => $record->trading_license ? asset('storage/' . $record->trading_license) : null)
                            ->openUrlInNewTab(),
                        TextEntry::make('license_expiry')
                            ->label(__('License Expiry'))
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->color(fn ($record) => $record->license_expiry?->isPast() ? 'danger' : 'success')
                            ->visible(fn ($record) => !empty($record->license_expiry)),
                    ]),

                // Office Address
                Section::make(__('Office Address'))
                    ->icon('heroicon-o-home')
                    ->schema([
                        TextEntry::make('office_address')
                            ->label('')
                            ->prose()
                            ->columnSpanFull()
                            ->visible(fn ($record) => !empty($record->office_address)),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => empty($record->office_address)),

                // Verification Status
                Section::make(__('Verification Status'))
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('email_verified_at')
                            ->label(__('Email Verified'))
                            ->dateTime()
                            ->since()
                            ->icon('heroicon-o-envelope')
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                        TextEntry::make('phone_verified_at')
                            ->label(__('Phone Verified'))
                            ->dateTime()
                            ->since()
                            ->icon('heroicon-o-phone')
                            ->color(fn ($state) => $state ? 'success' : 'danger'),
                    ]),

                // Timestamps
                Section::make(__('Timeline'))
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime()
                            ->since()
                            ->color('gray'),
                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime()
                            ->since()
                            ->icon('heroicon-o-calendar-days')
                            ->color('gray'),
                    ]),
            ]);
    }
}

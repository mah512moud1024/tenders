<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $types = ['client', 'consultant', 'contractor', 'subcontractor', 'supplier'];
        $type = $this->faker->randomElement($types);

        $businessName = null;
        $businessNameEn = null;
        $officeAddress = null;
        $tradingLicense = null;
        $licenseExpiry = null;

        if ($type !== 'client') {
            $businessName = $this->faker->company;
            $businessNameEn = $this->faker->company;
            $officeAddress = $this->faker->address;
            $tradingLicense = 'licenses/' . Str::random(10) . '.pdf';
            $licenseExpiry = $this->faker->dateTimeBetween('now', '+2 years');
        }

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'type' => $type,
            'business_name' => $businessName,
            'business_name_en' => $businessNameEn,
            'office_address' => $officeAddress,
            'trading_license' => $tradingLicense,
            'license_expiry' => $licenseExpiry,
            'approved' => $this->faker->boolean(80), // 80% chance of being approved
            'remember_token' => Str::random(10),
        ];
    }

    public function client()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'client',
                'business_name' => null,
                'business_name_en' => null,
                'office_address' => null,
                'trading_license' => null,
                'license_expiry' => null,
            ];
        });
    }

    public function consultant()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'consultant',
                'approved' => true,
            ];
        });
    }

    public function contractor()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'contractor',
                'approved' => true,
            ];
        });
    }

    public function supplier()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'supplier',
                'approved' => true,
            ];
        });
    }

    public function unapproved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved' => false,
            ];
        });
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

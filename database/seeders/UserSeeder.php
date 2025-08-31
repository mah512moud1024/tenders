<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ServiceArea;
use App\Models\City;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@tenders.com',
            'phone' => '+966500000001',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'approved' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create 10 clients
        for ($i = 1; $i <= 10; $i++) {
            $client = User::create([
                'first_name' => 'Client',
                'last_name' => 'User' . $i,
                'email' => 'client' . $i . '@tenders.com',
                'phone' => '+9665000000' . sprintf('%02d', $i + 1),
                'password' => Hash::make('password'),
                'type' => 'client',
                'approved' => true,
                'email_verified_at' => now(),
            ]);
            $client->assignRole('client');
        }

        // Create 5 consultants
        for ($i = 1; $i <= 5; $i++) {
            $consultant = User::create([
                'first_name' => 'Consultant',
                'last_name' => 'User' . $i,
                'email' => 'consultant' . $i . '@tenders.com',
                'phone' => '+9665100000' . sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'type' => 'consultant',
                'business_name' => 'Consultant Firm ' . $i,
                'business_name_en' => 'Consultant Firm ' . $i,
                'office_address' => 'Office Address ' . $i . ', Riyadh, Saudi Arabia',
                'trading_license' => 'licenses/consultant' . $i . '.pdf',
                'license_expiry' => now()->addYears(2),
                'approved' => true,
                'email_verified_at' => now(),
            ]);
            $consultant->assignRole('consultant');

            // Add service areas for consultants
            $cities = City::inRandomOrder()->limit(3)->get();
            foreach ($cities as $city) {
                ServiceArea::create([
                    'user_id' => $consultant->id,
                    'city_id' => $city->id,
                ]);
            }
        }

        // Create 5 contractors
        for ($i = 1; $i <= 5; $i++) {
            $contractor = User::create([
                'first_name' => 'Contractor',
                'last_name' => 'User' . $i,
                'email' => 'contractor' . $i . '@tenders.com',
                'phone' => '+9665200000' . sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'type' => 'contractor',
                'business_name' => 'Contractor Company ' . $i,
                'business_name_en' => 'Contractor Company ' . $i,
                'office_address' => 'Office Address ' . $i . ', Jeddah, Saudi Arabia',
                'trading_license' => 'licenses/contractor' . $i . '.pdf',
                'license_expiry' => now()->addYears(2),
                'approved' => true,
                'email_verified_at' => now(),
            ]);
            $contractor->assignRole('contractor');

            // Add service areas for contractors
            $cities = City::inRandomOrder()->limit(3)->get();
            foreach ($cities as $city) {
                ServiceArea::create([
                    'user_id' => $contractor->id,
                    'city_id' => $city->id,
                ]);
            }
        }

        // Create 5 suppliers
        for ($i = 1; $i <= 5; $i++) {
            $supplier = User::create([
                'first_name' => 'Supplier',
                'last_name' => 'User' . $i,
                'email' => 'supplier' . $i . '@tenders.com',
                'phone' => '+9665300000' . sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'type' => 'supplier',
                'business_name' => 'Supplier Company ' . $i,
                'business_name_en' => 'Supplier Company ' . $i,
                'office_address' => 'Office Address ' . $i . ', Dammam, Saudi Arabia',
                'trading_license' => 'licenses/supplier' . $i . '.pdf',
                'license_expiry' => now()->addYears(2),
                'approved' => true,
                'email_verified_at' => now(),
            ]);
            $supplier->assignRole('supplier');

            // Add service areas for suppliers
            $cities = City::inRandomOrder()->limit(3)->get();
            foreach ($cities as $city) {
                ServiceArea::create([
                    'user_id' => $supplier->id,
                    'city_id' => $city->id,
                ]);
            }
        }

        // Create some unapproved service providers
        for ($i = 1; $i <= 3; $i++) {
            $unapproved = User::create([
                'first_name' => 'Unapproved',
                'last_name' => 'User' . $i,
                'email' => 'unapproved' . $i . '@tenders.com',
                'phone' => '+9665400000' . sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'type' => 'consultant',
                'business_name' => 'Unapproved Firm ' . $i,
                'business_name_en' => 'Unapproved Firm ' . $i,
                'office_address' => 'Office Address ' . $i . ', Riyadh, Saudi Arabia',
                'trading_license' => 'licenses/unapproved' . $i . '.pdf',
                'license_expiry' => now()->addYears(2),
                'approved' => false,
                'email_verified_at' => now(),
            ]);
            $unapproved->assignRole('consultant');
        }
    }
}

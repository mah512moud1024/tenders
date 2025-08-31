<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        $this->truncateTables();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Seed countries and cities
        $this->call(CountryCitySeeder::class);

        // Seed project categories
        $this->call(ProjectCategorySeeder::class);

        // Seed subscription plans
        $this->call(SubscriptionPlanSeeder::class);

        // Seed users with roles
        $this->call(UserSeeder::class);

        // Seed tenders
        $this->call(TenderSeeder::class);

        // Seed quotes
        $this->call(QuoteSeeder::class);

        // Seed contracts
        $this->call(ContractSeeder::class);

        // Seed subscriptions and transactions
        $this->call(SubscriptionTransactionSeeder::class);
    }

    protected function truncateTables()
    {
        $tables = [
            'users',
            'countries',
            'cities',
            'service_areas',
            'project_categories',
            'tenders',
            'tender_specifications',
            'quotes',
            'quote_documents',
            'contracts',
            'subscription_plans',
            'subscriptions',
            'transactions',
            'invoices',
            'model_has_roles',
            'model_has_permissions',
            'roles',
            'permissions',
            'role_has_permissions',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}

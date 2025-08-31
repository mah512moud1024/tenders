<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = ['admin', 'client', 'consultant', 'contractor', 'subcontractor', 'supplier'];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        // Create permissions
        $permissions = [
            'view tenders', 'create tender', 'edit tender', 'delete tender', 'publish tender',
            'view quotes', 'create quote', 'edit quote', 'delete quote', 'accept quote',
            'view contracts', 'create contract', 'edit contract', 'delete contract', 'sign contract',
            'view users', 'create user', 'edit user', 'delete user', 'approve user',
            'view subscriptions', 'create subscription', 'edit subscription', 'cancel subscription',
            'view transactions', 'create transaction', 'refund transaction',
            'manage platform settings', 'view reports', 'export data'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $clientRole = Role::findByName('client');
        $clientRole->givePermissionTo([
            'view tenders', 'create tender', 'edit tender', 'delete tender', 'publish tender',
            'view quotes', 'accept quote', 'view contracts', 'create contract', 'sign contract'
        ]);

        $consultantRole = Role::findByName('consultant');
        $consultantRole->givePermissionTo([
            'view tenders', 'view quotes', 'create quote', 'edit quote', 'delete quote',
            'view contracts', 'sign contract'
        ]);

        $contractorRole = Role::findByName('contractor');
        $contractorRole->givePermissionTo([
            'view tenders', 'view quotes', 'create quote', 'edit quote', 'delete quote',
            'view contracts', 'sign contract'
        ]);

        $supplierRole = Role::findByName('supplier');
        $supplierRole->givePermissionTo([
            'view tenders', 'view quotes', 'create quote', 'edit quote', 'delete quote',
            'view contracts', 'sign contract'
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Permission;
use Shopper\Core\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    private string $guard = 'web';

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->createPermissions();
        $roles = $this->createRoles();

        $this->syncPermissions($roles);
        $this->removeDuplicateAdminRole();
        $this->removeDuplicateCustomerRole();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function createPermissions(): void
    {
        foreach ($this->permissions() as $name => $meta) {
            Permission::query()->updateOrCreate([
                'name' => $name,
                'guard_name' => $this->guard,
            ], [
                'group_name' => $meta['group'],
                'display_name' => $meta['display'],
                'description' => $meta['description'],
                'can_be_removed' => false,
            ]);
        }
    }

    private function createRoles(): array
    {
        $roles = [];

        foreach ($this->roles() as $name => $meta) {
            $roles[$name] = Role::query()->updateOrCreate([
                'name' => $name,
                'guard_name' => $this->guard,
            ], [
                'display_name' => $meta['display'],
                'description' => $meta['description'],
                'can_be_removed' => false,
            ]);
        }

        return $roles;
    }

    private function syncPermissions(array $roles): void
    {
        $allPermissions = Permission::query()->pluck('name')->all();

        $roles['administrator']->syncPermissions($allPermissions);

        foreach ($this->rolePermissions() as $role => $permissions) {
            $existingPermissions = Permission::query()
                ->whereIn('name', $permissions)
                ->pluck('name')
                ->all();

            $roles[$role]->syncPermissions($existingPermissions);
        }
    }

    private function roles(): array
    {
        return [
            'administrator' => [
                'display' => 'Administrator',
                'description' => 'Full system access through Shopper and ZeShop modules.',
            ],
            'manager' => [
                'display' => 'Manager',
                'description' => 'Day-to-day operations across orders, deliveries, messages, and reports.',
            ],
            'accountant' => [
                'display' => 'Accountant',
                'description' => 'Financial reports, vouchers, commissions, and order history.',
            ],
            'stock_manager' => [
                'display' => 'Stock Manager',
                'description' => 'Inventory, products, categories, brands, and collections.',
            ],
            'delivery_person' => [
                'display' => 'Delivery Person',
                'description' => 'Delivery fulfillment and assigned delivery tracking.',
            ],
            'seller' => [
                'display' => 'Seller',
                'description' => 'Product listing and commission visibility.',
            ],
            'user' => [
                'display' => 'Customers',
                'description' => 'End buyer access for own orders and profile.',
            ],
        ];
    }

    private function permissions(): array
    {
        $resources = [
            'commissions' => 'Commissions',
            'deliveries' => 'Deliveries',
            'reports' => 'Reports',
            'messages' => 'Messages',
            'vouchers' => 'Vouchers',
            'suppliers' => 'Suppliers',
            'transactions' => 'Transactions',
            'history' => 'History',
            'profile' => 'Profile',
        ];

        $permissions = [];

        foreach ($resources as $resource => $label) {
            foreach (['browse', 'read', 'add', 'edit', 'delete'] as $action) {
                $permissions[$action . '_' . $resource] = [
                    'group' => $resource,
                    'display' => ucfirst($action) . ' ' . $label,
                    'description' => 'Allows users to ' . $action . ' ' . strtolower($label) . '.',
                ];
            }
        }

        return $permissions;
    }

    private function rolePermissions(): array
    {
        return [
            'manager' => [
                'access_dashboard',
                'browse_orders',
                'read_orders',
                'edit_orders',
                'browse_deliveries',
                'read_deliveries',
                'add_deliveries',
                'edit_deliveries',
                'browse_messages',
                'read_messages',
                'add_messages',
                'edit_messages',
                'delete_messages',
                'browse_reports',
                'read_reports',
                'add_reports',
            ],
            'accountant' => [
                'access_dashboard',
                'browse_orders',
                'read_orders',
                'browse_reports',
                'read_reports',
                'add_reports',
                'delete_reports',
                'browse_vouchers',
                'read_vouchers',
                'add_vouchers',
                'edit_vouchers',
                'browse_commissions',
                'read_commissions',
                'edit_commissions',
                'browse_transactions',
                'read_transactions',
                'browse_history',
                'read_history',
            ],
            'stock_manager' => [
                'access_dashboard',
                'browse_products',
                'read_products',
                'add_products',
                'edit_products',
                'delete_products',
                'browse_inventories',
                'read_inventories',
                'add_inventories',
                'edit_inventories',
                'delete_inventories',
                'browse_suppliers',
                'read_suppliers',
                'add_suppliers',
                'edit_suppliers',
                'browse_brands',
                'read_brands',
                'browse_categories',
                'read_categories',
                'browse_collections',
                'read_collections',
            ],
            'delivery_person' => [
                'access_dashboard',
                'browse_deliveries',
                'read_deliveries',
                'edit_deliveries',
            ],
            'seller' => [
                'access_dashboard',
                'browse_products',
                'read_products',
                'add_products',
                'edit_products',
                'browse_commissions',
                'read_commissions',
            ],
            'user' => [
                'browse_orders',
                'read_orders',
                'browse_profile',
                'read_profile',
                'edit_profile',
            ],
        ];
    }

    private function removeDuplicateAdminRole(): void
    {
        $admin = Role::query()->where('name', 'admin')->first();
        $administrator = Role::query()->where('name', config('shopper.core.users.admin_role'))->first();

        if (! $admin || ! $administrator) {
            return;
        }

        $adminAssignments = DB::table('model_has_roles')
            ->where('role_id', $admin->id)
            ->get();

        foreach ($adminAssignments as $assignment) {
            DB::table('model_has_roles')->updateOrInsert([
                'role_id' => $administrator->id,
                'model_type' => $assignment->model_type,
                'model_id' => $assignment->model_id,
            ]);
        }

        DB::table('model_has_roles')
            ->where('role_id', $admin->id)
            ->delete();

        DB::table('role_has_permissions')
            ->where('role_id', $admin->id)
            ->delete();

        $admin->delete();
    }

    private function removeDuplicateCustomerRole(): void
    {
        $customer = Role::query()->where('name', 'customer')->first();
        $defaultCustomer = Role::query()->where('name', config('shopper.core.users.default_role'))->first();

        if (! $customer || ! $defaultCustomer) {
            return;
        }

        $customerAssignments = DB::table('model_has_roles')
            ->where('role_id', $customer->id)
            ->get();

        foreach ($customerAssignments as $assignment) {
            DB::table('model_has_roles')->updateOrInsert([
                'role_id' => $defaultCustomer->id,
                'model_type' => $assignment->model_type,
                'model_id' => $assignment->model_id,
            ]);
        }

        DB::table('model_has_roles')
            ->where('role_id', $customer->id)
            ->delete();

        DB::table('role_has_permissions')
            ->where('role_id', $customer->id)
            ->delete();

        $customer->delete();
    }
}

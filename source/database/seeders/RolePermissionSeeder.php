<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $superAdminRole = Role::create(['name' => 'super admin']);

        // Create permissions
        $modules = ['header', 'slider', 'product', 'category', 'blog', 'subscribers', 'contactEntries', 'testimonials', 'pages', 'adds', 'orders'];
        $actions = ['view', 'add', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$module}"]);
            }
        }

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all()); // Super admin gets all permissions
        $adminRole->givePermissionTo(Permission::whereIn('name', [
            'view header', 'add header', 'edit header',
            // Add other permissions as needed
        ])->get());

        // Assign roles to users for testing
        $user = User::find(2); // Replace with your user ID
        if ($user) {
            $user->assignRole('admin');
            $user->givePermissionTo(['view header', 'add header']); // Assign some permissions directly for testing
        }

        // Optionally, assign the super admin role to a user
        $superAdmin = User::find(1); // Replace with the super admin user ID
        if ($superAdmin) {
            $superAdmin->assignRole('super admin');
        }
    }
}


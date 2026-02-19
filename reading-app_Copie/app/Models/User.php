<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'book.view',
            'book.create',
            'book.edit',
            'book.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $adminRole = Role::findOrCreate('admin');
        $editorRole = Role::findOrCreate('editor');

        $adminPermissions = Permission::query()
            ->whereIn('name', $permissions)
            ->get();

        $editorPermissions = Permission::query()
            ->whereIn('name', [
                'book.view',
                'book.create',
                'book.edit',
            ])
            ->get();

        $adminRole->syncPermissions($adminPermissions);
        $editorRole->syncPermissions($editorPermissions);

        $admin = User::where('email', 'admin@books.com')->first();
        if ($admin) {
            $admin->syncRoles(['admin']);
        }

        $editor = User::where('email', 'editor@books.com')->first();
        if ($editor) {
            $editor->syncRoles(['editor']);
        }
    }
}
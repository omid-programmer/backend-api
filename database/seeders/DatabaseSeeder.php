<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $roleInDatabase = \Spatie\Permission\Models\Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                \Spatie\Permission\Models\Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = \Spatie\Permission\Models\Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (config('permission.default_permissions') as $permission) {
                \Spatie\Permission\Models\Permission::create([
                    'name' => $permission
                ]);
            }
        }

        Thread::factory()->count(10)->create();
    }
}

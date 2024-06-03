<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $admin = User::create([
        //     'name' => 'Admin Role',
        //     'email' => 'root@root.com',
        //     'password' => bcrypt('root'),
        // ]);

        // $admin->assignRole('admin');

        $user = User::where('name', 'Root')->first();

        if ($user) {
            $role = Role::where('name', 'Admin')->first();
        } else {
            $user = new User();
            $user->name = 'Root';
            $user->username = 'root';
            $user->email = 'root@root.com';
            $user->password = Hash::make('root');

            $user->save();

            $role = Role::create(['name' => 'Admin']);
        }

        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}

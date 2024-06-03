<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
        $this->call(PermissionTableSeeder::Class);
        // $this->call(RoleSeeder::Class);
        $this->call(UserSeeder::Class);
        // $this->call(RestaurantSeeder::Class);
        // $this->call(BiliardSeeder::Class);
        // $this->call(MeetingRoomSeeder::Class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => 'admin@mail.com',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('roles')->insert([
            'role_name' => "Admin",
            'role_level' => '3',
            'user_id' => 1,
        ]);
    }
}

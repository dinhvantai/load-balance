<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' =>  'admin@gmail.com',
            'name' =>  'Admin',
            'password' =>  'admin123',
            'permission' =>  User::PERMISSION_ADMIN,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $param1 = [
            'name' => 'user1',
            'user_name' => 'ユーザー1',
            'email' => 'user1@test.com',
            'password' =>Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        User::create($param1);

        $param2 = [
            'name' => 'user2',
            'user_name' => 'ユーザー2',
            'email' => 'user2@test.com',
            'password' =>Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        User::create($param2);

        $param3 = [
            'name' => 'user3',
            'user_name' => 'ユーザー3',
            'email' => 'user3@test.com',
            'password' =>Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        User::create($param3);
    }
}
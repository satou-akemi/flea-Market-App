<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'user1',
            'user_name' => 'ユーザー1',
            'email' => 'user1@test.com',
            'password' =>Hash::make('password'),
        ];
        user::create($param);

        $param = [
            'name' => 'user2',
            'user_name' => 'ユーザー2',
            'email' => 'user2@test.com',
            'password' =>Hash::make('password'),
        ];
        user::create($param);

        $param = [
            'name' => 'user3',
            'user_name' => 'ユーザー１',
            'email' => 'user1@test.com',
            'password' =>Hash::make('password'),
        ];
        user::create($param);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $email = 'user' . $i . '@example.com';

            $exists = DB::table('users')->where('email', $email)->exists();
            if (!$exists) {
                DB::table('users')->insert([
                    'name' => 'ユーザー' . $i,
                    'user_name' => 'ユーザー' . $i,
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
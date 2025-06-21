<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'ファッション', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => '家電', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'インテリア', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'レディース', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'メンズ', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'コスメ', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => '雑貨', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => '食品', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'name' => 'アクセサリー', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

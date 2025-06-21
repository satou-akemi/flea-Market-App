<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category_product')->truncate();
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = now();

        DB::table('products')->insert([
        [
            'user_id' => 1,
            'name' => '腕時計',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 2,
            'name' => 'HDD',
            'price' => '5000',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 3,
            'name' => '玉ねぎ３束',
            'price' => '300',
            'description' => '新鮮な玉ねぎ３束のセット',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 4,
            'name' => '革靴',
            'price' => '4000',
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 5,
            'name' => 'ノートPC',
            'price' => '45000',
            'description' => '高機能なノートパソコン',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 6,
            'name' => 'マイク',
            'price' => '8000',
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 7,
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 8,
            'name' => 'タンブラー',
            'price' => '500',
            'description' => '使いやすいタンブラー',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 9,
            'name' => 'コーヒーミル',
            'price' => '4000',
            'description' => '手動のコーヒーミル',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 10,
            'name' => 'メイクセット',
            'price' => '2500',
            'description' => '便利なメイクセットアップ',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし',
            'is_recommended' => true,
            'is_in_mylist' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ]);


        DB::table('category_product')->insert([
            ['product_id' => 1, 'category_id' => 1],
            ['product_id' => 1, 'category_id' => 5],
            ['product_id' => 2, 'category_id' => 2],
            ['product_id' => 3, 'category_id' => 8],
            ['product_id' => 4, 'category_id' => 1],
            ['product_id' => 4, 'category_id' => 5],
            ['product_id' => 5, 'category_id' => 2],
            ['product_id' => 6, 'category_id' => 2],
            ['product_id' => 7, 'category_id' => 1],
            ['product_id' => 7, 'category_id' => 4],
            ['product_id' => 8, 'category_id' => 7],
            ['product_id' => 9, 'category_id' => 7],
            ['product_id' => 10, 'category_id' => 6],
        ]);
    }
}

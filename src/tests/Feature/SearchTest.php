<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_部分一致()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product1 = Product::factory()->create(['name' => 'カメラ']);
        $product2 = Product::factory()->create(['name' => 'スマートフォン']);

        $response = $this->get(route('product.index',['keyword'=>'カメラ']));
        $response->assertStatus(200);
        $response->assertSee('カメラ');
        $response->assertDontSee('スマートフォン');
    }

    public function test_検索状態保持(){
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);
        $this->actingAs($user);

        $response = $this->get('/?keyword=カメラ');
        $response->assertStatus(200);

        $response->assertSee('tab=mylist');
        $response->assertSee('カメラ');
        }

        public function test_商品情報取得(){
            $user = User::factory()->create();
            $this->actingAs($user);

            $product = Product::factory()->create([
                'name' => 'テスト商品',
                'brand_name' => 'テストブランド',
                'condition' => '良好',
                'description' => 'これはテストです',
                'price' => 5000,
                'image_path' => 'test.jpg',
            ]);

            $product->likes()->attach($user->id);
            $product->comments()->create([
                'user_id' => $user->id,
                'body' => 'テストコメント',
            ]);

            $response = $this->get('/product/' . $product->id);
            $response->assertStatus(200);

            $response->assertSee('テスト商品');
            $response->assertSee('テストブランド');
            $response->assertSee('5,000');
            $response->assertSee('テストコメント');
            $response->assertSee('良好');
            $response->assertSee('これはテストです');
            $response->assertSee('test.jpg');

            $response->assertSee((string) $product->likes()->count());
            $response->assertSee((string) $product->comments()->count());
        }

        public function test_カテゴリ複数選択(){
            $user = User::factory()->create();
            $this->actingAs($user);

            $product = Product::factory()->create(['name' => 'テスト商品',]);

            $categories = Category::factory()->count(2)->create();
            $product->categories()->attach($categories->pluck('id'));

            $response = $this->get('/product/' . $product->id);
            $response->assertStatus(200);
            foreach($categories as $category){
            $response->assertSee($category->name);
            }
        }

}

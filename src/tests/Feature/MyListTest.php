<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;
use App\Models\Category;

class MyListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品だけ表示()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $otherUser = User::factory()->create();

        $likedProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'name'=> 'いいねした商品',
        ]);
        $notLikedProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'name' =>'いいねしてない商品',
        ]);

        $user->likes()->attach($likedProduct->id);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSeeText('いいねしてない商品');
    }

    public function test_購入済みをsoldマイリスト(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'is_sold' => true,
            'name' => 'ダミー商品',
        ]);
        $user->likes()->attach($product->id);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('ダミー商品');
        $response->assertSee('SOLD');
    }

    public function test_自分が出品した商品は非表示(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create([
            'user_id' =>$user->id,
            'name' => '自分の商品',
        ]);

        $otherUser = User::factory()->create();
        $likedProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'name' =>'他人の商品',
        ]);
        $user->likes()->attach($likedProduct->id);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSeeText($product->name);
    }

    public function test_未認証は非表示(){
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('class="product-card"');
    }
}

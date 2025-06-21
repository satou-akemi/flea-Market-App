<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_全商品取得()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_sold表示一覧から(){
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create([
            'is_sold' => true,
            'is_recommended' => true,
            'user_id' => $otherUser->id,
            'name' => '購入済みの商品',
        ]);

        $response = $this->get('/?keyword=購入済み');
        $response ->assertStatus(200);
        $response->assertSee('SOLD');
        $response->assertSeeText('購入済みの商品');
    }

    public function test_複数選択カテゴリ(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $categories = Category::factory()->count(2)->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        $product->categories()->attach($categories->pluck('id'));

        $response = $this->get(route('product.show', $product->id));

        foreach($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}

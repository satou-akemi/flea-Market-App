<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_情報取得()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar' => 'test/profile.jpg',
        ]);

        $sellProduct =  Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        $buyProduct = Product::factory()->create([
            'name' =>'購入商品B',
        ]);

        $address = Address::factory()->create([
            'user_id' => $user->id,
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'product_id' => $buyProduct->id,
            'address_id' => $address->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee('test/profile.jpg');
        $response->assertSee('テストユーザー');
        $response->assertSee('/mypage?page=buy');
        $response->assertSee('購入商品B');


        $response = $this->get('/mypage?page=sell');
        $response->assertStatus(200);
        $response->assertSee('test/profile.jpg');
        $response->assertSee('テストユーザー');
        $response->assertSee('/mypage?page=sell');
        $response->assertSee('出品商品A');
    }
}

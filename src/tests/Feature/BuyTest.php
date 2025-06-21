<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

class BuyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_購入()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/order/create/' . $product->id);
        $response->assertStatus(200);

        $buydata = [
        'product_id' => $product->id];

        $response = $this->post('/order/store', $buydata);
        $response->assertStatus(302);

        $this->assertDatabaseHas('orders',[
            'user_id' => $user->id,
            'product_id' =>$product->id,
        ]);
    }

    public function test_SOLD表示()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $response = $this->get('/order/create/' . $product->id);
        $response->assertStatus(200);
        $buydata = [
            'product_id' => $product->id];
        $response = $this->post('/order/store', $buydata);
        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' =>$product->id,
        ]);

        $this->assertDatabaseHas('products',[
            'id' => $product->id,
            'is_sold' => true,
        ]);

        $response = $this->get('/product');
        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }

    public function test_購入した一覧へ追加(){
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/order/create/' . $product->id);
        $response->assertStatus(200);
        $buydata = [
            'product_id' => $product->id];
        $response = $this->post('/order/store', $buydata);
        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' =>$product->id,
        ]);

        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }
}

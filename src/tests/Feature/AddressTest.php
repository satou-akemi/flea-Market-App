<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_住所反映()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $address = Address::factory()->create([
            'user_id' =>$user->id,
            'postal_code' => '123-4567',
            'prefecture' => '福岡県福岡市中央区1-1-1',
            'building' => 'テストビル101',
        ]);

        $this->actingAs($user);

        $response = $this->get('/order/create/' . $product->id);
        $response->assertStatus(200);

        $response->assertSee('〒123-4567');
        $response->assertSee('福岡県福岡市中央区1-1-1');
        $response->assertSee('テストビル101');
    }

    public function test_購入商品に住所紐付け()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $address = Address::factory()->create([
            'user_id' =>$user->id,
            'postal_code' => '123-4567',
            'prefecture' => '福岡県福岡市中央区1-1-1',
            'building' => 'テストビル101',
        ]);

        $this->actingAs($user);

            $response = $this->post('/order/store',[
                'product_id' => $product->id,
                'payment_method' => 'カード払い',
            ]);
            $response->assertStatus(302);
    
            $this->assertDatabaseHas('orders',[
                'user_id' => $user->id,
                'product_id' =>$product->id,
                'address_id' => $address->id,
            ]);
    }
}

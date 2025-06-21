<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_支払い()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $address = Address::factory()->create([
        'user_id' => $user->id]);

        $this->actingAs($user);

        // 小計画面が開けること
        $response = $this->get('/order/create/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('選択してください');

        // 支払い方法を送信
        $response = $this->post('/order/store', [
            'product_id' => $product->id,
            'payment_method' => 'credit_card',
        ]);

        $response->assertRedirect();

        // データベースに反映されているか
        $this->assertDatabaseHas('orders',[
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'credit_card',
        ]);

        // 支払い方法が画面で選択状態になっているか
        $response = $this->get('/order/create/' . $product->id);
    }
}

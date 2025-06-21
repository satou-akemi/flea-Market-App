<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいね登録()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $product->refresh();

        $response = $this->get('/product/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee((string)
        $product->likes()->count());
    }

    public function test_いいね色変わる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        $response = $this->get('/like/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('like-button liked');
    }

    public function test_再度いいねで解除(){
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        $product->refresh();
        $this->assertEquals(1, $product->likes()->count());

        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        $product->refresh();
        $this->assertEquals(0, $product->likes()->count());
    }
}

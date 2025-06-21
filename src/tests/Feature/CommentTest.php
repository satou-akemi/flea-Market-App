<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_コメント保存増加()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $commentData = [
            'body' => 'テストコメントです'];

        $this->post('/comment/' . $product->id, $commentData);

        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'product_id' => $product->id,
            'body' => 'テストコメントです',
        ]);

        $response = $this->get('/product/' . $product->id);
        $response->assertStatus(200);

        $product->refresh();
        $this->assertEquals(1, $product->comments()->count());
        $response->assertSeeText('1');
    }

    public function test_コメントできない(){
        $product = Product::factory()->create();
        $commentData = [
        'body' => 'テストコメントです'];

        $response = $this->post('/comment/' . $product->id, $commentData);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments',[
            'product_id' => $product->id,
            'body' => 'テストコメントです',
        ]);
    }

    public function test_コメントなしバリデーション()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/comment/' . $product->id,[
            'body' => '',
        ]);

        $response->assertSessionHasErrors(['body']);
        $errors = session('errors')->get('body');
        $this->assertContains('コメントを入力してください',$errors);
    }

    public function test_コメント２５５以上バリデーション()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ',256);
        $response = $this->post('/comment/' . $product->id,[
            'body' => $longComment,
        ]);

        $response->assertSessionHasErrors(['body']);
        $errors = session('errors')->get('body');
        $this->assertContains('２５５文字以内で入力してください',$errors);
    }
}

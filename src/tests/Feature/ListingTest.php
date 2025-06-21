<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ListingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_出品()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $categories = Category::factory()->count(2)->create();

        $response = $this->get(route('product.listing'));
        $response->assertStatus(200);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('test.jpg');

        $postData = [
            'category_ids' => $categories->pluck('id')->toArray(),
            'condition' => '良好',
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'image_path' => $file,
            'description' => 'テスト商品説明',
            'price' => 2000,
        ];

        $response = $this->post(route('product.store') , $postData);

        $response->assertStatus(302);

        Storage::disk('public')->assertExists('products/' . $file->hashName());

        $this->assertDatabaseHas('products',[
            'name' => 'テスト商品',
            'brand_name' =>'テストブランド',
            'description' => 'テスト商品説明',
            'price' => 2000,
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        foreach($categories as $category){
            $this->assertDatabaseHas('category_product',[
                'category_id' => $category->id,
                'product_id' => Product::latest()->first()->id,
            ]);
        }
    }
}

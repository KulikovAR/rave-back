<?php

namespace Tests\Feature\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_product()
    {
        $user = User::where('email','admin@admin')->first();
        $category = Category::factory()->create();
        $data = [
            'category_id' => $category->id,
            'name' => 'Test Product',
            'description' => 'Product Description',
            'price' => 100,
            'weight' => 500,
            'calories' => 200,
            'priority' => 1,
        ];

        $response = $this->actingAs($user)->post('/api/v1/products', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function can_update_product()
    {
        $user = User::where('email','admin@admin')->first();
        $product = Product::factory()->create();
        $data = ['name' => 'Updated Product'];

        $response = $this->actingAs($user)->put('/api/v1/products/' . $product->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function can_delete_product()
    {
        $user = User::where('email','admin@admin')->first();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete('/api/v1/products/' . $product->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function can_list_products()
    {
        $user = User::where('email','admin@admin')->first();
        $product = Product::factory()->create();
        
        $response = $this->actingAs($user)->get('/api/v1/products');
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }
}
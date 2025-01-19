<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User; 
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_category()
    {
        $user = User::where('email','admin@admin')->first();

        $restaurant = Restaurant::factory()->create();
        $data = [
            'name' => 'Test Category',
            'restaurant_id' => $restaurant->id,
            'priority' => 1,
            'hidden' => false,
        ];

        $response = $this->actingAs($user)->post('/api/v1/categories', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function can_update_category()
    {
        $user = User::where('email','admin@admin')->first();

        $category = Category::factory()->create();
        $data = ['name' => 'Updated Category'];

        $response = $this->actingAs($user)->put('/api/v1/categories/' . $category->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function can_delete_category()
    {
        $user = User::where('email','admin@admin')->first();

        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete('/api/v1/categories/' . $category->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function can_list_categories()
    {
        $user = User::where('email','admin@admin')->first();

        $category = Category::factory()->create();
        
        $response = $this->actingAs($user)->get('/api/v1/categories');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'restaurant_id',
                    'priority',
                    'hidden',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
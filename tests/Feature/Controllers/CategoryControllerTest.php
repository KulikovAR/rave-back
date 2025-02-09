<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_category_with_image()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create();
        $image = UploadedFile::fake()->image('category_image.jpg');

        $data = [
            'name' => 'Test Category',
            'restaurant_id' => $restaurant->id,
            'priority' => 1,
            'hidden' => false,
            'image' => $image,
            'description' => 'This is a test description.',
        ];

        $response = $this->actingAs($user)->post('/api/v1/categories', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'restaurant_id' => $restaurant->id,
            'priority' => 1,
            'hidden' => false,
            'description' => 'This is a test description.',
        ]);

        Storage::disk('public')->assertExists('categories/'.$image->hashName());
    }

    /** @test */
    public function can_update_category_with_image()
    {
        $user = User::where('email', 'admin@admin')->first();

        $category = Category::factory()->create();
        $image = UploadedFile::fake()->image('updated_category_image.jpg');

        $data = ['name' => 'Updated Category', 'description' => 'Updated description.', 'image' => $image];

        $response = $this->actingAs($user)->put('/api/v1/categories/'.$category->id, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category', 'description' => 'Updated description.']);

        Storage::disk('public')->assertExists('categories/'.$image->hashName());
    }

    /** @test */
    public function can_delete_category_and_image()
    {
        $user = User::where('email', 'admin@admin')->first();

        $category = Category::factory()->create();
        $imagePath = $category->image;

        $response = $this->actingAs($user)->delete('/api/v1/categories/'.$category->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);

        Storage::disk('public')->assertMissing('categories/'.$imagePath);
    }

    /** @test */
    public function can_list_categories()
    {
        $user = User::where('email', 'admin@admin')->first();

        $category = Category::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/categories');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'restaurant_id',
                        'priority',
                        'hidden',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}

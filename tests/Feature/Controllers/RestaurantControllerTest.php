<?php

namespace Tests\Feature\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RestaurantControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_restaurant()
    {
        $user = User::where('email', 'admin@admin')->first();

        $file = UploadedFile::fake()->image('photo.jpg');
        $backgroundImage = UploadedFile::fake()->image('background.jpg');
        $mapImage = UploadedFile::fake()->image('map.jpg');

        $data = [
            'name' => 'Test Restaurant',
            'photo' => $file,
            'priority' => 1,
            'background_image' => $backgroundImage,
            'map_image' => $mapImage,
            'address' => '123 Test St',
        ];

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/v1/restaurants', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('restaurants', [
            'name' => 'Test Restaurant',
            'priority' => 1,
            'address' => '123 Test St',
        ]);

        Storage::disk('public')->assertExists('restaurants/'.$file->hashName());
        Storage::disk('public')->assertExists('restaurants/backgrounds/'.$backgroundImage->hashName());
        Storage::disk('public')->assertExists('restaurants/maps/'.$mapImage->hashName());
    }

    /** @test */
    public function can_update_restaurant()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create();

        $backgroundImage = UploadedFile::fake()->image('updated_background.jpg');
        $mapImage = UploadedFile::fake()->image('updated_map.jpg');

        $data = [
            'name' => 'Updated Restaurant',
            'background_image' => $backgroundImage,
            'map_image' => $mapImage,
            'address' => '456 Updated Ave',
        ];

        $response = $this->actingAs($user)->put('/api/v1/restaurants/'.$restaurant->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'Updated Restaurant',
            'background_image' => 'restaurants/backgrounds/'.$backgroundImage->hashName(),
            'map_image' => 'restaurants/maps/'.$mapImage->hashName(),
            'address' => '456 Updated Ave',
        ]);

        Storage::disk('public')->assertExists('restaurants/backgrounds/'.$backgroundImage->hashName());
        Storage::disk('public')->assertExists('restaurants/maps/'.$mapImage->hashName());
    }

    /** @test */
    public function can_delete_restaurant()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->delete('/api/v1/restaurants/'.$restaurant->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('restaurants', ['id' => $restaurant->id]);
    }

    /** @test */
    public function can_list_restaurants()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/restaurants');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'photo',
                        'priority',
                        'background_image',
                        'map_image',
                        'address',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}

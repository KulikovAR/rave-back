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

        $data = [
            'name' => 'Test Restaurant',
            'photo' => $file,
            'priority' => 1,
        ];

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/api/v1/restaurants', $data);
        $response->assertStatus(201); // Проверка успешного создания (201)
        $this->assertDatabaseHas('restaurants', [
            'name' => 'Test Restaurant',
            'priority' => 1,
        ]);

        // Проверяем, что изображение было сохранено
        Storage::disk('public')->assertExists('restaurants/'.$file->hashName());
    }

    /** @test */
    public function can_update_restaurant()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create(); // Создание фейкового ресторана
        $data = ['name' => 'Updated Restaurant'];

        $response = $this->actingAs($user)->put('/api/v1/restaurants/'.$restaurant->id, $data);
        $response->assertStatus(200); // Проверка успешного обновления (200)
        $this->assertDatabaseHas('restaurants', $data);
    }

    /** @test */
    public function can_delete_restaurant()
    {
        $user = User::where('email', 'admin@admin')->first();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->delete('/api/v1/restaurants/'.$restaurant->id);
        $response->assertStatus(200); // Проверка успешного удаления (200)
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
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }
}

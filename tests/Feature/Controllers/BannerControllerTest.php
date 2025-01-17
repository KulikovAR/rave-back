<?php

namespace Tests\Feature\Controllers;

use App\Models\Banner;
use App\Models\User; 
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BannerControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_banner()
    {
        $user = User::where('email','admin@admin')->first();

        $data = [
            'name' => 'Test Banner',
            'image_path' => '/test.jpg',
            'priority' => 1,
        ];

        $response = $this->actingAs($user) // аутентифицируем пользователя
                         ->post('/api/v1/banners', $data);
                         
        // dd($response);
        $response->assertStatus(201);
        $this->assertDatabaseHas('banners', $data);
    }

    /** @test */
    public function can_update_banner()
    {
        $user = User::where('email','admin@admin')->first();

        $banner = Banner::factory()->create();
        $data = ['name' => 'Updated Banner'];

        $response = $this->actingAs($user) // аутентифицируем пользователя
                         ->put('/api/v1/banners/' . $banner->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('banners', $data);
    }

    /** @test */
    public function can_delete_banner()
    {
        $user = User::where('email','admin@admin')->first();

        $banner = Banner::factory()->create();

        $response = $this->actingAs($user) // аутентифицируем пользователя
                         ->delete('/api/v1/banners/' . $banner->id);
                         
        $response->assertStatus(200);
        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
    }

    /** @test */
    public function can_list_banners()
    {
        $user = User::where('email','admin@admin')->first();

        $banner = Banner::factory()->create();

        $response = $this->actingAs($user) // аутентифицируем пользователя
                         ->get('/api/v1/banners');
                         
        $response->assertStatus(200);
        $response->assertSee($banner->name);
    }
}
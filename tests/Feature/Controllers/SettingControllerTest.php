<?php

namespace Tests\Feature\Controllers;

use App\Models\Setting;
use App\Models\User; 
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_setting()
    {
        $user = User::where('email','admin@admin')->first();

        $data = [
            'name' => 'Phone',
            'key' => 'phone_number',
            'value' => '1234567890',
        ];

        $response = $this->actingAs($user)->post('/api/v1/settings', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('settings', $data);
    }

    /** @test */
    public function can_update_setting()
    {
        $user = User::where('email','admin@admin')->first();

        $setting = Setting::factory()->create();
        $data = ['value' => '0987654321'];

        $response = $this->actingAs($user)->put('/api/v1/settings/' . $setting->key, $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('settings', ['key' => $setting->key, 'value' => $data['value']]);
    }

    /** @test */
    public function can_delete_setting()
    {
        $user = User::where('email','admin@admin')->first();

        $setting = Setting::factory()->create();

        $response = $this->actingAs($user)->delete('/api/v1/settings/' . $setting->key);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('settings', ['key' => $setting->key]);
    }

    /** @test */
    public function can_list_settings()
    {
        $user = User::where('email','admin@admin')->first();

        $setting = Setting::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/settings');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'key',
                    'value',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
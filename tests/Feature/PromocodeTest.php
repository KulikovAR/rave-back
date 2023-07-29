<?php

namespace Tests\Feature;

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PromocodeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_promo(): void
    {
        $response = $this->actingAs($this->getTestUser())
                         ->json('get', route('promocode.index'));

        $response->assertStatus(200);
    }

    public function test_show_promo(): void
    {

        $response = $this->actingAs($this->getTestUser())
                         ->json('get', route('promocode.index', ['id' => $this->getTestUser()->promoCodes()->first()->id]));

        $response->assertStatus(200);
    }

    public function test_create_promo(): void
    {
        $requestData = [
            'title'      => $this->faker->word,
            'promo_code' => $this->faker->word,
            'commission' => 5,
            'discount'   => 5,
        ];
        $response    = $this->actingAs($this->getTestUser())
                            ->json('post', route('promocode.store'), $requestData);

        $response->assertStatus(200);
    }


    public function test_update_promo(): void
    {
        $requestData = [
            'id'         => $this->getTestUser()->promoCodes()->first()->id,
            'title'      => $this->faker->word,
            'promo_code' => $this->faker->word,
            'commission' => 5,
            'discount'   => 5,
        ];
        $response    = $this->actingAs($this->getTestUser())
                            ->json('put', route('promocode.update'), $requestData);

        $response->assertStatus(200);
    }

    public function test_delete_promo(): void
    {
        $requestData = [
            'id' => $this->getTestUser()->promoCodes()->first()->id,
        ];
        $response    = $this->actingAs($this->getTestUser())
                            ->json('delete', route('promocode.destroy'), $requestData);

        $response->assertStatus(200);

        $this->assertSame(StatusEnum::OK->value, $response->json('status'));

    }
}

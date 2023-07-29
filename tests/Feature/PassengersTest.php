<?php

namespace Tests\Feature;

use App\Enums\PassengerTypeEnum;
use Database\Factories\OrderPassengerFactory;
use Tests\TestCase;

class PassengersTest extends TestCase
{
    public function test_index_passenger_with_pagination(): void
    {
        $response = $this->actingAs($this->getTestUser())
                         ->json('get', route('passengers.index'));

        $response->assertStatus(200);
        $responseData = $response->json('data');
        $this->assertNotEmpty($responseData[0]);

        $response->assertJsonStructure(
            [
                'data', 'links', 'meta'
            ]);
    }

    public function test_show_passenger(): void
    {
        $user        = $this->getTestUser();
        $passengerId = $user->passenger->first()->id;

        $response = $this->actingAs($user)
                         ->json('get', route('passengers.index', ['id' => $passengerId]));
        $response->assertStatus(200);
        $responseData = $response->json('data');
        $response->assertJsonStructure(
            [
                'data' =>
                    [
                        'id',
                        'type',
                        'firstname',
                        'lastname',
                        'birthday',
                        'gender',
                        'country',
                        'document_number'
                    ]
            ]);
        $this->assertNotEmpty($responseData);
    }


    public function test_store_passenger(): void
    {
        $inputData = (new OrderPassengerFactory())->definitionRequest();
        $user      = $this->getTestUser();
        $response  = $this->actingAs($user)
                          ->json('post', route('passengers.store'), $inputData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'data']);
        $responseData = $response->json('data');
        $this->assertNotEmpty($responseData);
    }

    public function test_update_passenger(): void
    {
        $user        = $this->getTestUser();
        $idPassenger = $user->passenger->first()->id;

        $inputData               = (new OrderPassengerFactory())->definitionRequest();
        $inputData['id']         = $idPassenger;
        $inputData['dummy_data'] = 'dummy_data';

        $response = $this->actingAs($user)
                         ->json('put', route('passengers.store'), $inputData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'data']);
        $responseData = $response->json('data');
        $this->assertNotEmpty($responseData);
    }

    public function test_delete_passenger(): void
    {
        $user        = $this->getTestUser();
        $idPassenger = $user->passenger->first()->id;

        $response = $this->actingAs($user)
                         ->json('delete', route('passengers.store'), ['id' => $idPassenger]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'data']);

    }

    public function test_passenger_type_is_generated(): void
    {
        $inputData             = (new OrderPassengerFactory())->definitionRequest();
        $inputData['birthday'] = $this->faker->dateTimeInInterval('- 4 years')->format('d.m.Y');

        $user     = $this->getTestUser();
        $response = $this->actingAs($user)
                         ->json('post', route('passengers.store'), $inputData);

        $response->assertStatus(200);

        $passengerType = $response->json('data')['type'];

        $this->assertSame(PassengerTypeEnum::CHILD->value, $passengerType);
    }

    public function test_validation_show_passenger(): void
    {
        $user = $this->getTestUser();

        $response = $this->actingAs($user)
                         ->json('get', route('passengers.index', ['id' => '$passengerId']));

        $response->assertStatus(422);

        $response->assertJsonStructure(
            [
                'message',
                'errors' => ['id']
            ]);
    }


}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AirportsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_search_countries_and_cities(): void
    {
        $inputData = ['airport' => 'Россия'];

        $response = $this->json('get', route('search-airports'), $inputData);
        $response->assertStatus(200);

        $dataResponse = $response->json('data');

        $this->assertCount(15, $dataResponse);

        $this->assertSame([
                              "code"    => "MOW",
                              "name"    => "Москва",
                              "name_en" => "Moscow",
                              "type"    => "city",
                              "weight"  => 2142603,
                              "country" => "Россия",
                              "city"    => null,
                              "city_en" => null,
                          ],
                          $dataResponse[0]);

        $this->assertSame([
                              "code"    => "AER",
                              "name"    => "Сочи",
                              "name_en" => "Adler/Sochi",
                              "type"    => "city",
                              "weight"  => 1002499,
                              "country" => "Россия",
                              "city"    => null,
                              "city_en" => null,
                          ],
                          $dataResponse[1]);

        $response->assertStatus(200);
    }

    public function test_search_cities_and_airport(): void
    {
        $inputData = ['airport' => 'Москва'];

        $response = $this->json('get', route('search-airports'), $inputData);
        $response->assertStatus(200);

        $dataResponse = $response->json('data');

        $this->assertCount(4, $dataResponse);

        $this->assertSame([
                              "code"    => "MOW",
                              "name"    => "Москва",
                              "name_en" => "Moscow",
                              "type"    => "city",
                              "weight"  => 2142603,
                              "country" => "Россия",
                              "city"    => null,
                              "city_en" => null,
                          ],
                          $dataResponse[0]);

        $this->assertSame([
                              "code"    => "SVO",
                              "name"    => "Шереметьево",
                              "name_en" => "Sheremetyevo International Airport",
                              "type"    => "airport",
                              "weight"  => 641331,
                              "country" => "Россия",
                              "city"    => "Москва",
                              "city_en" => "Moscow",
                          ],
                          $dataResponse[1]);

        $this->assertSame([
                              "code"    => "VKO",
                              "name"    => "Внуково",
                              "name_en" => "Vnukovo Airport",
                              "type"    => "airport",
                              "weight"  => 438605,
                              "country" => "Россия",
                              "city"    => "Москва",
                              "city_en" => "Moscow",
                          ],
                          $dataResponse[2]);

        $this->assertSame([
                              "code"    => "DME",
                              "name"    => "Домодедово",
                              "name_en" => "Moscow Domodedovo Airport",
                              "type"    => "airport",
                              "weight"  => 370145,
                              "country" => "Россия",
                              "city"    => "Москва",
                              "city_en" => "Moscow",
                          ],
                          $dataResponse[3]);

    }

    public function test_search_airport_code_or_name(): void
    {
        $inputData  = ['airport' => 'Шереметьево'];
        $inputData2 = ['airport' => 'SVO'];

        $outputData = [
            "code"    => "SVO",
            "name"    => "Шереметьево",
            "name_en" => "Sheremetyevo International Airport",
            "type"    => "airport",
            "weight"  => 641331,
            "country" => "Россия",
            "city"    => "Москва",
            "city_en" => "Moscow"
        ];

        $response = $this->json('get', route('search-airports'), $inputData);
        $response->assertStatus(200);
        $dataResponse = $response->json('data');
        $this->assertCount(1, $dataResponse);
        $this->assertSame($outputData, $dataResponse[0]);

        $response     = $this->json('get', route('search-airports'), $inputData2);
        $dataResponse = $response->json('data');
        $this->assertCount(1, $dataResponse);
        $this->assertSame($outputData, $dataResponse[0]);


    }
}

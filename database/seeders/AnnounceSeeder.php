<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Announce;
use App\Models\Short;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AnnounceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        Announce::factory()->hasAttached(
            Tag::all()->random(rand(1, 3)),
        )->count(5)->create();

        $announce = Announce::factory()->hasAttached(
            Tag::all()->random(rand(1, 3)),
        )->create([
            'main' => true
        ]);


    }
}
<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class TagSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }
        $data = [
            [
                'name'  => 'Биология',
                'slug'  => 'biology',
                'image' => url('/tags/biology.svg')
            ],
            [
                'name'  => 'Химия',
                'slug'  => 'chemistry',
                'image' => url('/tags/chemistry.svg')
            ],
            [
                'name'  => 'Философия',
                'slug'  => 'philosophy',
                'image' => url('/tags/philosophy.svg')
            ],
            [
                'name'  => 'Литература',
                'slug'  => 'literature',
                'image' => url('/tags/literature.svg')
            ],
            [
                'name'  => 'История',
                'slug'  => 'history',
                'image' => url('/tags/history.svg')
            ],
            [
                'name'  => 'Искусство',
                'slug'  => 'art',
                'image' => url('/tags/art.svg')
            ],
            [
                'name'  => 'География',
                'slug'  => 'geography',
                'image' => url('/tags/geography.svg')
            ],
            [
                'name'  => 'Психология',
                'slug'  => 'psychology',
                'image' => url('/tags/psychology.svg')
            ],
            [
                'name'  => 'Физкультура',
                'slug'  => 'physical-education',
                'image' => url('/tags/physical_education.svg')
            ],
            [
                'name'  => 'Речь',
                'slug'  => 'speech',
                'image' => url('/tags/speech.svg')
            ],
            [
                'name'  => 'Астрономия',
                'slug'  => 'astronomy',
                'image' => url('/tags/astronomy.svg')
            ],
            [
                'name'  => 'Математика',
                'slug'  => 'math',
                'image' => url('/tags/math.svg')
            ],
        ];

        foreach($data as $tag) {
            Tag::factory()->create($tag);
        }
    }
}
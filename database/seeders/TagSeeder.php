<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

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
                'image' => '/tags/biology.svg'
            ],
            [
                'name'  => 'Химия',
                'slug'  => 'chemistry',
                'image' => '/tags/chemistry.svg'
            ],
            [
                'name'  => 'Философия',
                'slug'  => 'philosophy',
                'image' => '/tags/philosophy.svg'
            ],
            [
                'name'  => 'Литература',
                'slug'  => 'literature',
                'image' => '/tags/literature.svg'
            ],
            [
                'name'  => 'История',
                'slug'  => 'history',
                'image' => '/tags/history.svg'
            ],
            [
                'name'  => 'Искусство',
                'slug'  => 'art',
                'image' => '/tags/art.svg'
            ],
            [
                'name'  => 'География',
                'slug'  => 'geography',
                'image' => '/tags/geography.svg'
            ],
            [
                'name'  => 'Психология',
                'slug'  => 'psychology',
                'image' => '/tags/psychology.svg'
            ],
            [
                'name'  => 'Физкультура',
                'slug'  => 'physical-education',
                'image' => '/tags/physical_education.svg'
            ],
            [
                'name'  => 'Речь',
                'slug'  => 'speech',
                'image' => '/tags/speech.svg'
            ],
            [
                'name'  => 'Астрономия',
                'slug'  => 'astronomy',
                'image' => '/tags/astronomy.svg'
            ],
            [
                'name'  => 'Математика',
                'slug'  => 'math',
                'image' => '/tags/math.svg'
            ],
        ];

        foreach($data as $tag) {
            Tag::factory()->create($tag);
        }
    }
}
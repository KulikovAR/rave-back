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
                'image' => Storage::disk('private')->url('/tags/biology.svg')
            ],
            [
                'name'  => 'Химия',
                'slug'  => 'chemistry',
                'image' => Storage::disk('private')->url('/tags/chemistry.svg')
            ],
            [
                'name'  => 'Философия',
                'slug'  => 'philosophy',
                'image' => Storage::disk('private')->url('/tags/philosophy.svg')
            ],
            [
                'name'  => 'Литература',
                'slug'  => 'literature',
                'image' => Storage::disk('private')->url('/tags/literature.svg')
            ],
            [
                'name'  => 'История',
                'slug'  => 'history',
                'image' => Storage::disk('private')->url('/tags/history.svg')
            ],
            [
                'name'  => 'Искусство',
                'slug'  => 'art',
                'image' => Storage::disk('private')->url('/tags/art.svg')
            ],
            [
                'name'  => 'География',
                'slug'  => 'geography',
                'image' => Storage::disk('private')->url('/tags/geography.svg')
            ],
            [
                'name'  => 'Психология',
                'slug'  => 'psychology',
                'image' => Storage::disk('private')->url('/tags/psychology.svg')
            ],
            [
                'name'  => 'Физкультура',
                'slug'  => 'physical-education',
                'image' => Storage::disk('private')->url('/tags/physical_education.svg')
            ],
            [
                'name'  => 'Речь',
                'slug'  => 'speech',
                'image' => Storage::disk('private')->url('/tags/speech.svg')
            ],
            [
                'name'  => 'Астрономия',
                'slug'  => 'astronomy',
                'image' => Storage::disk('private')->url('/tags/astronomy.svg')
            ],
            [
                'name'  => 'Математика',
                'slug'  => 'math',
                'image' => Storage::disk('private')->url('/tags/math.svg')
            ],
        ];

        foreach($data as $tag) {
            Tag::factory()->create($tag);
        }
    }
}
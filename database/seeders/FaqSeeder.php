<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Faq;
use App\Models\FaqTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class FaqSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }
        
        $tags = [
            [
                'name' => 'Общее',
            ],
            [
                'name' => 'Оплата',
            ],
            [
                'name' => 'Видео-уроки',
            ],
        ];

        $faqs = [
            [
                'question' => 'Как работает TrueSchool?',
                'answer' => 'Вы можете поменять месячную подписку на годовой тариф «Премиум» или перейти на тариф «Ультима». Отмените текущую подписку и после завершения ее срока действия подпишитесь на другой тариф. Тариф «Ультима» бессрочный, поэтому изменить его нельзя.'
            ],
            [
                'question' => 'Что такое видеоуроки?',
                'answer'   => 'Вы можете поменять месячную подписку на годовой тариф «Премиум» или перейти на тариф «Ультима». Отмените текущую подписку и после завершения ее срока действия подпишитесь на другой тариф. Тариф «Ультима» бессрочный, поэтому изменить его нельзя.'
            ]
        ];

        foreach ($tags as $tag) {
            $faq_tag = FaqTag::create($tag);

            foreach($faqs as $faq) {
                Faq::create($faq + ['faq_tag_id' => $faq_tag->id]);
            }
        }
    }
}
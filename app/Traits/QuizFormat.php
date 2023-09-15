<?php

namespace App\Traits;

use App\Enums\SettingTagEnum;

trait QuizFormat
{
    protected function formatQuizForClient(): array
    {
        $response = $this->data;

        foreach($this->data as $key => $item) {
            unset($response[$key]['answers']);
            foreach($item['answers'] as $answer_item) {
                $response[$key]['answers'][] = $answer_item['answer'];
            }
        }

        return $response;
    }
}
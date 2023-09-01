<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCommentLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lesson_id'  => 'uuid|nullable|exists:lessons,id',
            'comment_id' => 'uuid|nullable|exists:comments,id',
            'body'       => 'string|required'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (is_null($this->input('comment_id')) && is_null($this->input('lesson_id'))) {
                    $validator->errors()->add(
                        'id',
                        __('The lesson_id and comment_id fields cannot be null at the same time', ['attribute' => 'id'])
                    );
                }
            }
        ];
    }
}
<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreQuizResultRequest extends FormRequest
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
            "quiz_id"         => 'required|exists:quizzes,id',
            "data"            => "required|array",
            "data.*.question" => 'required|string|max:255',
            "data.*.answer"  => 'required|string|max:255'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (
                    $this->user()->quiz_results()->where([
                        'quiz_id' => $this->input('email'),
                        'user_id' => $this->user()->id
                    ])->first()
                ) {
                    $validator->errors()->add('quiz_result', __('validation.exist', ['attribute' => 'quiz_result']));
                }
            }
        ];
    }
}
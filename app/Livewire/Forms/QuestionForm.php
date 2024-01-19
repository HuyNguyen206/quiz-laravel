<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class QuestionForm extends Form
{
    public $question_text = '';

    public $code_snippet = '';

    public $answer_explanation = '';

    public $more_info_link = '';

    public array $question_options = [];

    public function rules()
    {
        return [
            'question_text' => [
                'required',
                'string',
            ],
            'code_snippet' => 'required|string|nullable',
            'answer_explanation' => 'required|string|nullable',
            'more_info_link' => 'required|url|nullable',
            'question_options' => [
                'required',
                'array',
            ],
            'question_options.*.option' => [
                'required',
                'string',
            ],
        ];
    }
}

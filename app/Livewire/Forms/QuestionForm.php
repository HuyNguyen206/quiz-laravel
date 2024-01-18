<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class QuestionForm extends Form
{
    #[Validate('required|string')]
    public $question_text = '';

    #[Validate('string|nullable|required')]
    public $code_snippet = '';

    #[Validate('string|nullable|required')]
    public $answer_explanation = '';

    #[Validate('url|nullable|required')]
    public $more_info_link = '';

}

<?php

namespace App\Livewire\Forms;

use App\Models\Question;
use Illuminate\Support\Str;
use Livewire\Form;

class QuizForm extends Form
{
    public string $title = '';
    public string $slug = '';
    public ?bool $published = false;

    public ?bool $public = false;
    public ?string $description = '';

    public array $questions = [];
    public array $questionIds = [];

    public function initListsForFields(): void
    {
        $this->questions = Question::pluck('question_text', 'id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'title'       => [
                'string',
                'required',
            ],
            'slug'        => [
                'string',
                'nullable',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'published'   => [
                'boolean',
            ],
            'public'      => [
                'boolean',
            ],
        ];
    }
}

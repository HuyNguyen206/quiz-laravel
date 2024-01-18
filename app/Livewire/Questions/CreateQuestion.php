<?php

namespace App\Livewire\Questions;

use App\Livewire\Forms\QuestionForm;
use App\Models\Question;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Livewire\Component;

class CreateQuestion extends Component
{
    public QuestionForm $form;

    public bool $editing = false;

    public function mount(Question $question): void
    {
        if ($question->exists) {
            $this->editing = true;
        }
    }

    public function save(): Redirector
    {
        $this->validate();

        Question::create($this->form->all());

        return to_route('questions');
    }

    public function render(): View
    {
        return view('livewire.questions.create-question');
    }
}

<?php

namespace App\Livewire\Quiz;

use App\Livewire\Forms\QuizForm;
use App\Models\Quiz;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class CreateQuiz extends Component
{
    public QuizForm $form;

    public Quiz $quiz;

    public bool $editing = false;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz;
        $this->form->initListsForFields();
        if ($this->quiz->exists) {
            $this->editing = true;
            $this->form->fill($this->quiz);
            $this->form->questionIds = $this->quiz->questions()->pluck('questions.id')->toArray();

        } else {
            $this->form->published = false;
            $this->form->public = false;
        }
    }

    public function updatedFormTitle(): void
    {
        $this->form->slug = Str::slug($this->form->title);
    }

    public function save(): Redirector
    {
        $this->validate();

        if (!$this->quiz->exists) {
            $quiz = Quiz::create($this->form->except(['questions', 'questionIds']));
            $this->quiz = $quiz;
        } else {
            $this->quiz->fill($this->form->except(['questions', 'questionIds']));
            $this->quiz->save();
        }
        $this->quiz->questions()->sync($this->form->questionIds);

        return to_route('quizzes');
    }

    public function render(): View
    {
        return view('livewire.quiz.create-quiz');
    }

}

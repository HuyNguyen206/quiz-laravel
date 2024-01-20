<?php

namespace App\Livewire\Questions;

use App\Livewire\Forms\QuestionForm;
use App\Models\Question;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class CreateQuestion extends Component
{
    public QuestionForm $form;

    public Question $question;

    public bool $editing = false;

    public function mount(Question $question): void
    {
        $this->question = $question;
        if ($this->question->exists) {
            $this->form->fill($question);
            $this->editing = true;
            foreach ($question->questionOptions as $option) {
                $this->form->question_options[] = [
                    'option'  => $option->option,
                    'correct' => $option->correct,
                ];
            }
        }
    }

    public function addQuestionsOption(): void
    {
        $this->form->question_options[] = [
            'option' => '',
            'correct' => false
        ];
    }

    public function removeQuestionsOption(int $index): void
    {
        unset($this->form->question_options[$index]);
        $this->form->question_options = array_values(($this->form->question_options));
    }

    public function save(): Redirector
    {
        $this->validate();

        try {
            DB::beginTransaction();
            if ($this->question->exists) {
                $this->question->update($this->form->except('question_options'));
                $this->question->questionOptions()->delete();
            } else {
                $this->question = Question::create($this->form->except('question_options'));
            }

            $this->question->questionOptions()->createMany($this->form->question_options);
            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            throw new \Exception($exception);
        }

        return to_route('questions');
    }

    public function render(): View
    {
        return view('livewire.questions.create-question');
    }
}

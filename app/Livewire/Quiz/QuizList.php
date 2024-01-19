<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Livewire\Component;

class QuizList extends Component
{
    public function render(): View
    {
        $quizzes = Quiz::latest()->paginate();

        return view('livewire.quiz.quiz-list', compact('quizzes'));
    }

    public function delete(Quiz $quiz)
    {
        abort_if(! auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->delete();
    }
}

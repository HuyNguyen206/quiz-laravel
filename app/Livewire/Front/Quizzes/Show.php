<?php

namespace App\Livewire\Front\Quizzes;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\TestAnswer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public Collection $questions;

    public Question $currentQuestion;

    public int $currentQuestionIndex = 0;

    public array $questionsAnswers = [];

    public int $startTimeSeconds = 0;

    public function mount(): void
    {
        $this->startTimeSeconds = now()->timestamp;

        $this->questions = Question::query()
            ->oldest()
            ->whereRelation('quizzes','quizzes.id', $this->quiz->id)
            ->with('questionOptions')
            ->get();
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        for($i = 0; $i < $this->questionsCount; $i++) {
            $this->questionsAnswers[$i] = [];
        }
    }

    public function getQuestionsCountProperty(): int
    {
        return $this->questions->count();
    }

    public function changeQuestion(): void
    {
        $this->currentQuestionIndex++;
        $this->questions = $this->questions->sortBy('created_at')->values();
        if ($this->currentQuestionIndex >= $this->questionsCount) {
             $this->submit();
        }
        $this->currentQuestion = $this->questions->sortByDesc('created_at')[$this->currentQuestionIndex];
    }

    public function submit()
    {
        $result = 0;

        DB::beginTransaction();
        try {
            $test = Test::create([
                'user_id'    => auth()->id(),
                'quiz_id'    => $this->quiz->id,
                'result'     => 0,
                'ip_address' => request()->ip(),
                'time_spent' => now()->timestamp - $this->startTimeSeconds
            ]);

            foreach ($this->questionsAnswers as $key => $option) {
                $status = 0;

                if (! empty($option) && QuestionOption::find($option)->correct) {
                    $status = 1;
                    $result++;
                }

                TestAnswer::create([
                    'user_id'     => auth()->id(),
                    'test_id'     => $test->id,
                    'question_id' => $this->questions[$key]->id,
                    'option_id'   => $option ?? null,
                    'correct'     => $status,
                ]);
            }

            $test->update([
                'result' => $result,
            ]);
            DB::commit();
        } catch (\Throwable $throwable) {
            DB::rollBack();

            throw $throwable;
        }


        return to_route('results.show', $test);
    }

    public function render()
    {
        return view('livewire.front.quizzes.show');
    }
}

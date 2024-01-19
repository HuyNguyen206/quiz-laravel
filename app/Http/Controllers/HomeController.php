<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $query = Quiz::query()
            ->whereHas('questions')
            ->withCount('questions')
            ->when(auth()->user()?->isAdmin(), function (Builder $builder) {
                $builder->where('published', true);
            });
        $secondQuery = clone $query;
        $publicQuizzes = $query->where('public', true)->latest()->paginate();
        $registeredQuizzes = $secondQuery->where('public', false)->latest()->paginate();

        return view('home', compact('publicQuizzes', 'registeredQuizzes'));
    }

    public function show(Quiz $quiz, $slug = null)
    {
        return view('front.quizzes.show', compact( 'quiz'));
    }
}

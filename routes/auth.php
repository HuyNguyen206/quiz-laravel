<?php

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ResultController;
use App\Http\Middleware\IsAdmin;
use App\Livewire\Forms\QuizForm;
use App\Livewire\Questions\CreateQuestion;
use App\Livewire\Questions\QuestionList;
use App\Livewire\Quiz\CreateQuiz;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::get('results', [ResultController::class, 'index'])->name('results.index');


    Route::middleware(IsAdmin::class)->group(function () {
        Route::get('questions', QuestionList::class)->name('questions');
        Route::get('questions/create', CreateQuestion::class)->name('questions.create');
        Route::get('questions/{question}', CreateQuestion::class)->name('questions.edit');

        Route::get('quizzes', \App\Livewire\Quiz\QuizList::class)->name('quizzes');
        Route::get('quizzes/create', CreateQuiz::class)->name('quiz.create');
        Route::get('quizzes/{quiz}', CreateQuiz::class)->name('quiz.edit');

        Route::get('tests', TestController::class)->name('tests');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'loginSocial'])
        ->name('socialite.auth');

    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
        ->name('socialite.callback');
});

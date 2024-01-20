<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Forms\QuestionForm;
use App\Livewire\Questions\CreateQuestion;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateQuestion()
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateQuestion::class)
            ->set('form.question_text', 'very secret question')
            ->set('form.code_snippet', 'very secret question')
            ->set('form.answer_explanation', 'very secret question')
            ->set('form.more_info_link', 'https://livewire.laravel.com/docs/wire-model#updating-on-change-event')
            ->set('form.question_options.0.option', 'first answer')
            ->call('save')
            ->assertHasNoErrors(['form.question_text', 'form.code_snippet', 'form.answer_explanation', 'form.more_info_link', 'form.topic_id', 'form.question_options', 'form.question_options.*.option'])
            ->assertRedirect(route('questions'));

        $this->assertDatabaseHas('questions', [
            'question_text' => 'very secret question',
        ]);
    }

    public function testQuestionTextIsRequired()
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateQuestion::class)
//            ->set('form.question_text', '')
            ->call('save')
            ->assertHasErrors(['question_text' => 'required']);
    }

    public function testAdminCanEditQuestion()
    {
        $this->actingAs(User::factory()->admin()->create());

        $question = Question::factory()
            ->has(QuestionOption::factory())
            ->create();

        Livewire::test(CreateQuestion::class, [$question])
            ->set('form.question_text', 'very secret question')
            ->set('form.code_snippet', 'very secret question')
            ->set('form.answer_explanation', 'very secret question')
            ->set('form.more_info_link', 'https://livewire.laravel.com/docs/wire-model#updating-on-change-event')
            ->call('save')
            ->assertHasNoErrors(['form.question_text', 'form.question_options', 'form.question_options.*.option'])
            ->assertRedirect(route('questions'));

        $this->assertDatabaseHas('questions', [
            'question_text' => 'very secret question',
        ]);
    }
}

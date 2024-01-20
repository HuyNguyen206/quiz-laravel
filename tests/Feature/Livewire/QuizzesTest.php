<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Quiz\CreateQuiz;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuizzesTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateQuiz()
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateQuiz::class)
            ->set('form.title', 'quiz title')
            ->call('save')
            ->assertHasNoErrors(['form.title', 'form.slug', 'form.description', 'form.published', 'form.public', 'questions'])
            ->assertRedirect(route('quizzes'));

        $this->assertDatabaseHas('quizzes', [
            'title' => 'quiz title',
        ]);
    }

    public function testTitleIsRequired()
    {
        $this->actingAs(User::factory()->admin()->create());

        Livewire::test(CreateQuiz::class)
            ->set('form.title', '')
            ->call('save')
            ->assertHasErrors(['title' => 'required']);
    }

    public function testAdminCanEditQuiz()
    {
        $this->actingAs(User::factory()->admin()->create());

        $quiz = Quiz::factory()->create();

        Livewire::test(CreateQuiz::class, [$quiz])
            ->set('form.title', 'new quiz')
            ->set('form.published', true)
            ->call('save')
            ->assertSet('form.published', true)
            ->assertHasNoErrors(['form.title', 'form.slug', 'form.description', 'form.published', 'form.public', 'questions']);

        $this->assertDatabaseHas('quizzes', [
            'title' => 'new quiz',
            'published' => true,
        ]);
    }
}

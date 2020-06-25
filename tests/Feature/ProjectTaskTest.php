<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $this->post($project->path().'/tasks', ['body' => 'Test Task']);

        $this->get($project->path())->assertSee('Test Task');
    }

    /** @test */
    public function a_project_required_body_field(){
        $this->signIn();
        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path().'/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }
}

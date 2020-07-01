<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_add_tasks(){
        $project = factory('App\Project')->create();
        $this->post($project->path().'/tasks', ['body' => 'Test Task'])->assertRedirect('login');
    }

    /** @test */
    public function only_owner_project_can_add_task_to_them(){

        $project = factory('App\Project')->create();

        $this->signIn();

        $this->post($project->path().'/tasks', ['body' => 'Test Task'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }


    /** @test */
    public function a_project_has_tasks()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path().'/tasks', ['body' => 'Test Task']);

        $this->get($project->path())->assertSee('Test Task');
    }

    /** @test */
    public function project_task_can_be_update(){

        $project = ProjectFactory::create();

        $task = $project->addTask('test task');

        $attributes = [
            'body' => 'changed task',
            'completed' => true,
        ];

        $this->actingAs($project->owner)->patch($task->path(), $attributes);
        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function project_task_can_update_only_owner(){

        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('test task');

        $attributes = [
            'body' => 'changed task',
            'completed' => true,
        ];

        $this->patch($task->path(), $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function a_project_required_body_field(){
        $project = ProjectFactory::create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->actingAs($project->owner)->post($project->path().'/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }
}

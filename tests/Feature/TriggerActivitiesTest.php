<?php

namespace Tests\Feature;

use App\Activity;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_create()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);
        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'project_created',
        ]);
    }

    /** @test */
    public function a_project_update()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), ['title' => 'changed']);

        $this->assertCount(2, $project->activities);
        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'project_updated',
        ]);
    }

    /** @test */
    public function a_project_add_task()
    {

        $project = ProjectFactory::create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function($activity){
            $this->assertEquals('task_created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }

    /** @test */
    public function a_project_task_completed()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->complete();

        $this->assertCount(3, $project->activities);

        tap($project->activities->last(), function($activity){
            $this->assertEquals('task_completed', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'task_completed',
        ]);
    }

    /** @test */
    public function a_project_task_incompleted()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->complete();

        $this->assertCount(3, $project->activities);

        $project->tasks->first()->incomplete();

        $project = $project->refresh();

        $this->assertCount(4, $project->activities);

        tap($project->activities->last(), function($activity){
            $this->assertEquals('task_incompleted', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'task_incompleted',
        ]);
    }

    /** @test */
    function deleting_a_task(){
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activities);
    }
}

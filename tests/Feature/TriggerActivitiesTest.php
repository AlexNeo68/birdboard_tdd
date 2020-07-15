<?php

namespace Tests\Feature;

use App\Activity;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_creating_record_with_activity()
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
    public function a_project_updating_record_with_activity()
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
    public function a_project_add_task_with_activity()
    {

        $project = ProjectFactory::create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activities);

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'task_created',
        ]);
    }

    /** @test */
    public function a_project_task_completed_with_activity()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->complete();

        $this->assertCount(3, $project->activities);

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'task_completed',
        ]);
    }

    /** @test */
    public function a_project_task_incompleted_with_activity()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->complete();

        $this->assertCount(3, $project->activities);

        $project->tasks->first()->incomplete();

        $project = $project->refresh();

        $this->assertCount(4, $project->activities);

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

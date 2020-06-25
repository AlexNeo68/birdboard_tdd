<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_path()
    {
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function project_has_owner()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_has_addTask()
    {
        $project = factory('App\Project')->create();
        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}

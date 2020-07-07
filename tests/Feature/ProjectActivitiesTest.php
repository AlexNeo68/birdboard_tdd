<?php

namespace Tests\Feature;

use App\Activity;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_creating_activities_with_creating()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);
        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'created',
        ]);
    }

    /** @test */
    public function a_project_creating_activities_with_update()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), ['title' => 'changed']);

        $this->assertCount(2, $project->activities);
        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'description' => 'updated',
        ]);
    }
}

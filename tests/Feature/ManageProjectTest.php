<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_project()
    {
        $project = factory('App\Project')->create();
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_project()
    {

        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes there',
        ];

        $response = $this->post('/projects', $attributes);

        $this->assertDatabaseHas('projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get('/projects')->assertSee($attributes['title']);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_project()
    {

        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $this->patch($project->path(), ['notes' => 'changed'])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'changed']);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_project_to_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function user_can_view_create_page()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $project = factory('App\Project')->create([
            'owner_id' => $user->id,
            'description' => $this->faker->sentence
        ]);

        $this->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_project_field_title_required()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_field_description_required()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}

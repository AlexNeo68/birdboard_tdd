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

        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/' . $project->id)->assertRedirect('/login');

        $this->signIn();

        $this->get('/projects/' . $project->id)->assertStatus(403);
    }

    /** @test */
    public function user_can_view_create_page()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
    }
}

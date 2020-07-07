<?php

namespace App\Observers;

use App\Activity;
use App\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $this->createActivity($project, 'created');
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $this->createActivity($project, 'updated');
    }

    protected function createActivity($project, $type):void
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => $type
        ]);
    }
}

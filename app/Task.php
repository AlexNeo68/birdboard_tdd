<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function activities(){
        return $this->morphMany(Activity::class, 'subject');
    }

    public function createActivity($description):void
    {
        $this->activities()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }

    public function complete()
    {
        $this->update([ 'completed' => true ]);
        $this->createActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update([ 'completed' => false ]);
        $this->createActivity('task_incompleted');
    }
}

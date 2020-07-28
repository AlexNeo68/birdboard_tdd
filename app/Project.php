<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function addTask($body){
        return $this->tasks()->create(compact('body'));
    }

    public function activities(){
        return $this->hasMany(Activity::class)->latest();
    }

    public function createActivity($description):void
    {
        $this->activities()->create(compact('description'));
    }
}

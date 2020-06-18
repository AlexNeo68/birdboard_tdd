<?php

namespace App\Http\Controllers;

use App\Project;

class ProjectController extends Controller
{

    public function index(){
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store(){
        Project::create(request(['title', 'description']));
        return redirect('/projects');
    }
}

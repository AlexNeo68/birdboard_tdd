  @extends('layouts.app')
  @section('content')
    <div class="mb-3">
        <div class="flex justify-between items-center">
            <h2 class="text-muted text-base font-light">My Projects</h2>
            <a class="button" href="/projects/create">Create Project</a>
        </div>
    </div>

    <div class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>Projects not yet.</div>
        @endforelse
    </div>


  @endsection



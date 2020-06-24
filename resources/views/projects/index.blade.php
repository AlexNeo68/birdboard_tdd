  @extends('layouts.app')
  @section('content')
    <div class="mb-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg">My Projects</h2>
            <a class="button" href="/projects/create">Create Project</a>
        </div>

    </div>
    @if($projects)
        <div class="flex flex-wrap -mx-3">
            @forelse ($projects as $project)
                <div class="w-1/3 p-3">
                    <div class="bg-white rounded shadow p-4" style="height: 200px;">
                        <h3 class="text-xl py-4 border-blue-500 -mx-4 pl-4 mb-2 border-l-4">
                            <a href="{{url($project->path())}}">{{ $project->title }}</a>
                        </h3>
                        <div class="text-gray-600 text-sm">
                            {{ Str::limit($project->description, 100) }}
                        </div>
                    </div>


                </div>
            @empty
                <div>Projects not yet</div>
            @endforelse
        </div>

    @endif
  @endsection



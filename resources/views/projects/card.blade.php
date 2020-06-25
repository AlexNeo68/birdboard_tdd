<div class="card">
    <h3 class="font-normal text-xl py-4 border-l-4 -ml-5 border-blue-500 pl-4 mb-3">
        <a href="{{url($project->path())}}">{{ $project->title }}</a>
    </h3>
    <div class="flex-1">
        {{ Str::limit($project->description, 100) }}
    </div>
</div>

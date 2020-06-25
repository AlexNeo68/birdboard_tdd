@extends('layouts.app')

@section('content')

    <div class="mb-6 pb-4">
        <div>
            <p class="text-muted font-light">
                <a href="/projects" class="underline hover:no-underline">My Projects</a>
                / {{$project->title}}
            </p>
        </div>
    </div>

    <main>
        <div class="flex -mx-3">
            <div class="w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-lg text-muted font-light mb-3">Tasks</h2>
                    {{--tasks--}}
                    @forelse($project->tasks as $task)
                        <div class="card mb-3">{{$task->body}}</div>
                    @empty
                        <div>No task in this project</div>
                    @endforelse
                </div>
                <div>
                    <h2 class="text-lg text-muted font-light mb-3">General Notes</h2>
                    <form action="{{url($project->path())}}" method="POST">
                        @csrf
                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            placeholder="Anything special that you want to make a note of?"
                        ></textarea>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="w-1/4 px-3">
                @include('projects.card')
                {{ $project->description }}
            </div>
        </div>


    </main>

@endsection

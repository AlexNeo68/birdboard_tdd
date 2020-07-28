@extends('layouts.app')

@section('content')

    <div class="mb-6 pb-4 flex justify-between">
        <div>
            <p class="text-muted font-light">
                <a href="/projects" class="underline hover:no-underline">My Projects</a>
                / {{$project->title}}
            </p>
        </div>
        <div><a class="button" href="{{$project->path()}}/edit">Edit</a></div>
    </div>

    <main>
        <div class="flex -mx-3">
            <div class="w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-lg text-muted font-light mb-3">Tasks</h2>
                    {{--tasks--}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3" style="height: auto">
                            <form method="POST" action="{{$task->path()}}" class="flex items-center">
                                @method('PATCH')
                                @csrf
                                <input type="text" class="w-full {{$task->completed ? 'text-gray-600' : ''}}" name="body" value="{{$task->body}}">
                                <input type="checkbox" name="completed" {{$task->completed ? 'checked' : ''}} onchange="this.form.submit()" >
                            </form>

                        </div>
                    @endforeach

                    <form action="{{$project->path()}}/tasks" method="POST" class="card" style="height: auto">
                        @csrf
                        <input type="text" name="body" class="w-full" placeholder="Add New task ..." />
                    </form>
                </div>
                <div>
                    <h2 class="text-lg text-muted font-light mb-3">General Notes</h2>
                    <form action="{{url($project->path())}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            placeholder="Anything special that you want to make a note of?"
                        >{{$project->notes}}</textarea>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="w-1/4 px-3">
                @include('projects.card')
                @include('activities.card')
            </div>
        </div>
    </main>
@endsection

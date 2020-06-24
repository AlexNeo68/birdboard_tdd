@extends('layouts.app')

@section('content')

    <header>
        <div>
            <p>
                <a href="/projects">My Projects</a>
                / {{$project->title}}
            </p>
        </div>
    </header>

    <main>
        <div class="flex">
            <div class="w-3/4">
                <div>
                    <h2>Tasks</h2>
                </div>
                <div>
                    <h2>General Notes</h2>
                </div>
            </div>

            <div class="1/4">

            </div>
        </div>


    </main>

@endsection

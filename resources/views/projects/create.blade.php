  @extends('layouts.app')
  @section('content')
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/projects">
    @csrf
    @include('projects.form', ['buttonText' => 'Create', 'project' => new App\Project ])
  </form>
  @endsection


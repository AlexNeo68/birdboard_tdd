  @extends('layouts.app')
  @section('content')
      <h3>Edit the Project</h3>
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{$project->path()}}">
    @csrf
      @method('PATCH')
    @include('projects.form', ['buttonText' => 'Edit'])
  </form>
  @endsection


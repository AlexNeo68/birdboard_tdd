  @extends('layouts.app')
  @section('content')
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="/projects">
    @csrf
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Title
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="title" type="text" placeholder="Type title ...">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
        Description
      </label>
      <textarea name="description" placeholder="Type description ..."></textarea>
    </div>
    <div>
      <button type="submit">
        Create
      </button>
      <a href="/projects">Cancel</a>
    </div>
  </form>
  @endsection


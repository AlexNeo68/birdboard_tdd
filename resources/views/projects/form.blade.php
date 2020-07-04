
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2">
        Title
      </label>
      <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          name="title"
          type="text"
          placeholder="Type title ..."
          value="{{$project->title}}"
          required
      >
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2">
        Description
      </label>
      <textarea
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          name="description"
          required
          placeholder="Type description ...">{{$project->description}}</textarea>
    </div>
    <div>
      <button type="submit">
        {{$buttonText}}
      </button>
      <a href="/projects">Cancel</a>
    </div>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li class="text-sm text-red-400">{{$error}}</li>
            @endforeach
        </ul>
    @endif


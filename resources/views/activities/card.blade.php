<div class="card mt-4" style="height: auto">
    <ul class="text-sm">
        @foreach($project->activities as $activity)
            <li class="{{$loop->last ? '' : 'mb-1'}}">
                @include('activities.'.$activity->description)
                <span>{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>

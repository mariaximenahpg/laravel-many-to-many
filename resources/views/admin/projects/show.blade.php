@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="py-4">
        <h1>{{ $project->project_name }}</h1>
        <h3>
            @if ($project->type)
              Tipo: <a href="{{ route('admin.types.show', $project->type) }}">{{ $project->type->name }}</a>
            @else
              Senza Tipo
            @endif
        </h3>
        <h5>
          @if ($project->technologies->isNotEmpty())
            @foreach ($project->technologies as $technology)
              Tecnologia: <a href="#">{{ $technology->name }}</a>
            @endforeach
         @endif
       </h5>

        <div class="mt-4">
            @if($project->cover_image)
             <img class="w-25" src="{{ asset("storage/$project->cover_image")}}" alt="{{$project->project_name}}">
            @endif
            {{ $project->summary }}
        </div>
    </div>
</div>
@endsection
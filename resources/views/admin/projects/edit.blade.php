@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="py-4">
        <h1>Modifica: "{{ $project->project_name }}"</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mt-4">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="project_name" class="form-label">Nome del nuovo progetto</label>
                  <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Inserisci il nome del nuovo progetto" value="{{ old('project_name', $project->project_name)}}">
                </div>
                <div class="mb-3">
                    <label for="client_name" class="form-label">Nome del cliente</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Inserisci il nome del cliente" value="{{ old('client_name', $project->client_name)}}">
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Dettagli</label>
                    <textarea class="form-control" name="summary" id="summary" rows="10" placeholder="Inserisci una breve descrizione" value="{{ old('summary', $project->summary)}}"></textarea>
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Immagine</label>
                    <div>
                        <img id="output" width="100" class="mb-2" @if ($project->cover_image) src="{{ asset("storage/$project->cover_image")}}" @endif/>
                        <script>
                        var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function(){
                            var output = document.getElementById('output');
                            output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        };
                        </script>
                    </div>
                    <input type="file" class="form-control" id="cover_image" name="cover_image" value="{{ old('cover_image')}}" onchange="loadFile(event)">
                  </div>
                  <div class="mb-3">
                    <label for="type_id" class="form-label">Tipo</label>
                    <select class="form-select" name="type_id" id="type_id">
                      <option value="">Senza Tipo</option>
                      @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                          {{ old('type_id', $project->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <div class="mb-3">Tecnologie</div>
                    @foreach ($technologies as $technology)
                    <div class="form-check form-check-inline">
                    @if($errors->any())
                        <input class="form-check-input" name="technologies[]" type="checkbox" id="{{ $technology->slug }}" value="{{ $technology->id }}" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                    @else
                        <input class="form-check-input" name="technologies[]" type="checkbox" id="{{ $technology->slug }}" value="{{ $technology->id }}" {{ $project->technologies->contains($technology->id) ? 'checked' : '' }}>
                    @endif
                        <label class="form-check-label" for="{{ $technology->slug }}">{{ $technology->name }}</label>
                    </div>
                    @endforeach
                  </div>
                <button type="submit" class="btn btn-primary">Modifica</button>
            </form>
        </div>
    </div>
</div>
@endsection
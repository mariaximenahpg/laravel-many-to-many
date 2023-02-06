@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="py-4">
        <h1>Aggiungi nuovo progetto</h1>
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
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="project_name" class="form-label">Nome del nuovo progetto</label>
                  <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Inserisci il nome del nuovo progetto" value="{{ old('project_name')}}">
                </div>
                <div class="mb-3">
                    <label for="client_name" class="form-label">Nome del cliente</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Inserisci il nome del cliente" value="{{ old('client_name')}}">
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Dettagli</label>
                    <textarea class="form-control" name="summary" id="summary" rows="10" placeholder="Inserisci una breve descrizione" value="{{ old('summary')}}"></textarea>
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Immagine</label>
                    <div>
                        <img id="output" width="100" class="mb-2"/>
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
                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                          {{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <h4>Tecnologie</h4>
                    @foreach ($technologies as $technology)
                      <div class="form-check form-check-inline">
                        <input class="form-check-label" name="technologies[]" type="checkbox" id="{{ $technology->slug }}" value="{{ $technology->id }}" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $technology->slug }}">{{ $technology->name }}</label>
                      </div>
                    @endforeach
                  </div>
                <button type="submit" class="btn btn-primary">Crea</button>
            </form>
        </div>
    </div>
</div>
@endsection
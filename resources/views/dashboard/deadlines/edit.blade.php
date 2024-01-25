<x-Layouts.layoutDash>
    <h6 class="fw-bold">Modifica Documento</h6>
    
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('dashboard.deadlines.update', ['deadline' => $deadline->id]) }}" method="post" class="my-" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Utilizza il metodo PUT per l'aggiornamento -->
        
        <div class="row g-3">
            <div class="col-12">
                <label class="my-2" for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $deadline->name }}" required>
            </div>
            
            <div class="col-12">
                <label class="my-2" for="description">Descrizione</label>
                <textarea type="text" name="description" class="form-control">{{ $deadline->description }}</textarea>
            </div>
            
            <div class="col-12">
                <label class="my-2" for="tag">Tag</label>
                @foreach ($tags as $tag)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $deadline->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $tag->name }}</label>
                </div>
                @endforeach
            </div>
            
            
            <div class="col-6 mb-3">
                <label class="my-2" for="expiry_date">Data di Scadenza</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ Carbon\Carbon::parse($deadline->documentDeadlines->first()->expiry_date)->format('Y-m-d') }}" required>
            </div>                                
            
            
            <div class="col-6 mb-3">
                <label class="my-2" for="pdf">Documento</label>
                <input type="file" name="pdf" class="form-control">
            </div>
            
            
            <div class="row">
                <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
            </div>
        </div>
    </form>
    
</x-Layouts.layoutDash>
<x-Layouts.layoutDash>
    
    
    <h4 class="fw-bold m-4">Impostazioni Deadline</h4>
    
    <div class="row g-3 m-4">
        <div class="col-12 col-md-6">
            <form action="{{ route('dashboard.settings.deadlines.tagAdd') }}" method="post">
                @csrf
                <label class="mb-3" for="name">Aggiungi Tag: </label>
                <input class="form-control mb-3" type="text" name="name" required>
                <div class="row m-1">
                    <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                </div>
            </form>
        </div>
        
        <div class="col-12 col-md-3 ps-3 pt-3 bg-white border border-2">
            @if(count($tags) > 0)
            @foreach($tags as $tag)
            <form id="form" action="{{ route('dashboard.settings.deadlines.tagRemove', ['tagId' => $tag->id]) }}" method="post">
                @csrf
                @method('delete')
                <label class="mb-3" for="name">Tag: </label>
                <span class="badge bg-primary ms-3">{{$tag->name}}</span>
                <button class="btn" type="submit"><i class='bi bi-trash-fill text-danger fs-5'></i></button>
            </form>
            @endforeach
            @else
                <p class="fw-semibold text-center">Nessun Tag</p>
            @endif
        </div>
    </div>
    
</x-Layouts.layoutDash>
<x-Layouts.layoutDash>
    
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <x-allert />
            
            
            <h4 class="m-4 fw-bold">Impostazioni R4</h4>
            
            <div class="row g-3 m-4">
                <div class="col-12 col-md-6">
                    <form action="{{ route('dashboard.settings.r4.store') }}" method="post">
                        @csrf
                        <label class="mb-3" for="name">Tipo: </label>
                        <input class="form-control mb-3" type="text" name="name" required>
                        <div class="row m-2">
                            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                        </div>
                    </form>
                </div>
                
                <div class="col-12 col-md-3 ps-3 ms-3 pt-3 bg-white border border-2">
                    @if(count($typeR4) > 0)
                    @foreach($typeR4 as $type)
                    <form action="{{ route('dashboard.settings.r4.delete', ['typeR4Id' => $type->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <label class="mb-3" for="name">Tipo: </label>
                        <span class="badge bg-primary ms-3">{{$type->name}}</span>
                        <button class="btn" type="submit"><i class='bi bi-trash-fill text-danger fs-5'></i></button>
                    </form>
                    @endforeach
                    @else
                    <p class="fw-semibold text-center">Non ci sono Tipi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-Layouts.layoutDash>
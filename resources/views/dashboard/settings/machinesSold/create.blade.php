<x-Layouts.layoutDash>
    <div class="container">
    <div class="container d-flex justify-content-center my-2 fixed-top">
        @if (session('success'))
        <div class="alert alert-success mt-5">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger mt-5">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>
    <h4 class="fw-bold m-3">Impostazioni Macchine</h4>
    
    <div class="row g-3 m-3">

    <div class="col-12 col-md-6">
        <form action="{{ route('dashboard.settings.machinesSold.store') }}" method="post">
            @csrf
            <label class="mb-3" for="name">Aggiungi Garanzia: </label>
            <input class="form-control mb-3" type="text" name="name" required>
            <div class="row m-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
        </form>
    </div>
    
    <div class="col-12 col-md-3 ps-3 pt-3 bg-white border border-2">
        @if(count($warrantyType) > 0)
        @foreach($warrantyType as $warranty)
        <form action="{{ route('dashboard.settings.machinesSold.delete', ['warrantyId' => $warranty->id]) }}" method="post">
            @csrf
            @method('delete')
            <label class="mb-3" for="name">Garanzia: </label>
            <span class="badge bg-primary ms-3">{{$warranty->name}}</span>
            <button class="btn" type="submit"><i class='bi bi-trash-fill text-danger fs-5'></i></button>
        </form>
        @endforeach
        @else
        <p class="fw-semibold text-center">Nessuna Garanzia</p>
        @endif
    </div>
    
</x-Layouts.layoutDash>
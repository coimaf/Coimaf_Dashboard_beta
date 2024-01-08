<x-Layouts.LayoutDash>
    
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="container d-flex justify-content-center">
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
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    
                    <h1 class="m-5">Impostazioni Macchine</h1>
                    
                    <div class="row g-3 m-5">
                        <div class="col-12 col-md-6">
                            <form action="{{ route('dashboard.settings.machinesSold.store') }}" method="post">
                                @csrf
                                <label class="mb-3" for="name">Aggiungi Garanzia: </label>
                                <input class="form-control mb-3" type="text" name="name" required>
                                <div class="row">
                                    <x-Buttons.ButtonBlue type="submit" props="Aggiungi" />
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-12 col-md-6 ps-5">
                            @foreach($warrantyType as $warranty)
                            <form action="{{ route('dashboard.settings.machinesSold.delete', ['warrantyId' => $warranty->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <label class="mb-3" for="name">Garanzia: </label>
                                <span class="badge bg-primary ms-3">{{$warranty->name}}</span>
                                <button class="btn" type="submit"><i class='bi bi-trash-fill text-danger fs-5'></i></button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</x-Layouts.LayoutDash>
<x-Layouts.layoutDash>
    
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
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
           
                    
                 <h4 class="m-1 fw-bold">Impostazioni Tecnici</h4>
                    
                    <div class="row g-3 m-2">
                        <div class="col-12 col-md-6">
                            <form action="{{ route('dashboard.settings.tecnicians.store') }}" method="post">
                                @csrf
                                <label class="mb-3" for="name">Nome: </label>
                                <input class="form-control mb-3" type="text" name="name" required>
                                <label class="mb-3" for="surname">Cognome: </label>
                                <input class="form-control mb-3" type="text" name="surname" required>
                                <div class="row m-2">
                                    <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-12 col-md-3 ps-3 ms-3 pt-3 bg-white border border-2">
                            @if(count($technicians) > 0)
                            @foreach($technicians as $technician)
                            <form action="{{ route('dashboard.settings.tecnicians.delete', ['technician' => $technician->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <label class="mb-3" for="name">Tecnico: </label>
                                <span class="badge bg-primary ms-3">{{$technician->name}} {{$technician->surname}}</span>
                                <button class="btn" type="submit"><i class='bi bi-trash-fill text-danger fs-5'></i></button>
                            </form>
                            @endforeach
                            @else
                            <p class="fw-semibold text-center">Non ci sono Tecnici</p>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
    
</x-Layouts.layoutDash>
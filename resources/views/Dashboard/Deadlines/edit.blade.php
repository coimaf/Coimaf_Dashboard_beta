<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Modifica Documento</h2>
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                        <form action="{{ route('dashboard.deadlines.update', ['deadline' => $deadline->id]) }}" method="post" class="my-5" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Utilizza il metodo PUT per l'aggiornamento -->
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="my-2" for="name">Nome</label>
                                    <input type="text" name="name" class="form-control" value="{{ $deadline->name }}" required>
                                </div>
                                
                                <div class="col-6">
                                    <label class="my-2" for="description">Descrizione</label>
                                    <textarea type="text" name="description" class="form-control" required>{{ $deadline->description }}</textarea>
                                </div>
                                
                                <div class="col-6">
                                    <label class="my-2" for="tag">Tag</label>
                                    <input type="text" name="tag" class="form-control text-uppercase" value="{{ $deadline->tag }}" required>
                                </div>
                                
                                <div class="col-6 mb-3">
                                    <label class="my-2" for="expiry_date">Data di Scadenza</label>
                                    <input type="date" name="expiry_date" class="form-control" value="{{ Carbon\Carbon::parse($deadline->expiry_date)->format('d-m-Y') }}" required>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="my-2" for="pdf">Documento</label>
                                    <input type="file" name="pdf" class="form-control">
                                </div>

                            </div>
                            
                            <div class="row">
                                <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Layouts.layoutDash>
<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Aggiungi una nuova Macchina</h2>
                    
                    <form action="{{route('dashboard.machinesSolds.store')}}" method="POST" class="my-5" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="model">Modello</label>
                                <input type="text" name="model" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="brand">Marca</label>
                                <select name="brand" class="form-control">
                                    <option value="">Seleziona una Marca</option>
                                    <option value="arca">Arca</option>
                                    {{-- @foreach($brand as $brand_type)
                                    <option value="{{ $brand_type->id }}">{{ $brand_type->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="serial_number">Numero di Serie</label>
                                <input type="text" name="serial_number" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="sale_date">Data di vendita</label>
                                <input type="date" name="sale_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="first_buyer">Primo Acquirente</label>
                                <input type="text" name="first_buyer" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="current_owner">Proprietario Attuale</label>
                                <input type="text" name="current_owner" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="warranty_expiration_date">Data di scadenza garanzia</label>
                                <input type="date" name="warranty_expiration_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="my-2" for="warranty_type_id">Tipo Garanzia</label>
                                <select name="warranty_type_id" class="form-control" required>
                                    <option value="">Seleziona una garanzia</option>
                                    @foreach($warranty_type as $warranty)
                                        <option value="{{ $warranty->id }}">{{ $warranty->name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                                                        
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="registration_date">Data di registrazione</label>
                                <input type="date" name="registration_date" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="delivery_ddt">Consegna DDT</label>
                                <input type="text" name="delivery_ddt" class="form-control" required>
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="pb-3" for="notes">Note</label>
                                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" required></textarea>
                            </div>

                            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
</x-Layouts.layoutDash>
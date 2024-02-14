<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi Veicolo</h6>
    
    <form class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            
            <div class="col-12 col-md-4">
                <select class="form-control" name="type_vehicle_id" id="type_vehicle_id" required>
                    <option value="" selected disabled>Seleziona il tipo di veicolo*</option>
                    @foreach ($typeVehicles as $typeVehicle)                  
                    <option value="{{$typeVehicle->id}}">{{$typeVehicle->name}}</option>  
                    @endforeach            
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Marca*" type="text" name="brand" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Modello*" type="text" name="model" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Targa*" type="text" name="license_plate" class="form-control text-uppercase" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Telaio*" type="text" name="chassis" class="form-control text-uppercase" required>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Anno immatricolazione*" type="date" name="registration_year" class="form-control" required>
            </div>

            @foreach($documents as $document)
                <div class="col-12 col-md-6">
                    <div class="form-control my-3">
                        <label class="my-3" for="path_{{ $document->id }}">{{ $document->name }}</label>
                        <input type="file" class="form-control" id="path_{{ $document->id }}" name="documents[{{ $document->id }}][]">

                        <label class="my-3" for="expiry_date_{{ $document->id }}">Data di Scadenza per {{ $document->name }}</label>
                        <input type="date" class="form-control" id="expiry_date_{{ $document->id }}" name="expiry_dates[{{ $document->id }}]">
                    </div>
                </div>
            @endforeach

            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>

        </div>
    </form>
    
</x-Layouts.layoutDash>
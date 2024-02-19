<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi R4</h6>
    
    <form class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.fpc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
                        
            <div class="col-12 col-md-4">
                <input placeholder="Nome" type="text" name="name" class="form-control">
            </div>

            <div class="col-12 col-md-4">
                <select class="form-control" name="type_r4_id" id="type_r4_id">
                    <option value="" selected disabled>Seleziona il tipo</option>
                    @foreach ($typer4 as $type)                  
                    <option value="{{$type->id}}">{{$type->name}}</option>  
                    @endforeach            
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Matricola" type="text" name="serial_number" class="form-control">
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Assegnato a" type="text" name="assigned_to" class="form-control  mt-4 text-uppercase">
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Frequenza Controllo" type="text" name="control_frequency" class="form-control mt-4 text-uppercase">
            </div>

            <div class="col-12 col-md-4">
                <label for="buy_date">Data Acquisto</label>
                <input type="date" name="buy_date" class="form-control">
            </div>

            <div class="col-12 col-md-12">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control w-100" rows="4" style="resize: none;"></textarea>
            </div>
            
            
            
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
            
        </div>
    </form>
    
</x-Layouts.layoutDash>

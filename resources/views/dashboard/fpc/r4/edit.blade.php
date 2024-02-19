<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Modifica R4</h6>
    
    <form class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.r4.update', compact('r4')) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
                        
            <div class="col-12 col-md-4">
                <input placeholder="Nome" value="{{$r4->name}}" type="text" name="name" class="form-control">
            </div>

            <div class="col-12 col-md-4">
                <select class="form-control" name="type_r4_id" id="type_r4_id" required>            
                    @foreach ($typer4 as $type)    
                    <option value="{{$type->id}}" {{$r4->typer4->name == $type->name ? 'selected' : ''}}>{{$type->name}}</option>  
                    @endforeach            
                </select>                                              
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Matricola" value="{{$r4->serial_number}}" type="text" name="serial_number" class="form-control">
            </div>
            
            <div class="col-12 col-md-4">
                <input value="{{$r4->assigned_to}}" placeholder="Assegnato a" type="text" name="assigned_to" class="form-control  mt-4 text-uppercase">
            </div>
            
            <div class="col-12 col-md-4">
                <input value="{{$r4->control_frequency}}" placeholder="Frequenza Controllo" type="text" name="control_frequency" class="form-control mt-4 text-uppercase">
            </div>

            <div class="col-12 col-md-4">
                <label for="buy_date">Data Acquisto</label>
                <input value="{{$r4->buy_date}}" type="date" name="buy_date" class="form-control">
            </div>

            <div class="col-12 col-md-12">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control w-100" rows="4" style="resize: none;">{{ $r4->description }}</textarea>
            </div>
            
            
            
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
            
        </div>
    </form>
    
</x-Layouts.layoutDash>

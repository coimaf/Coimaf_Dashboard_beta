<x-Layouts.layoutDash>
    
    <div class="container-fluid px-4">
        <div class="row justify-content-end">
            <div class="col-3">
                <p class="card-footer fw-semibold mt-3">Creato da: {{$r4->user->name}}  il: {{$r4->created_at->format('d/m/Y')}} 
                    @if($r4->updated_by)
                    <br><br>Modificato da: {{$r4->updatedBy->name}} il: {{$r4->updated_at->format('d/m/Y')}}</p>
                    @endif
                <a href="{{ route('dashboard.r4.edit', compact('r4')) }}" class="btn btn-warning float-end fs-4 mt-3 me-4">Modifica</a>
            </div>
        </div>
    <div class="row mx-3 g-3">
        
        <div class="col-12 col-md-4">
            <label for="name">Nome</label>
            <input value="{{$r4->name}}" type="text" name="name" class="form-control" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="type">Tipo</label>
            <input value="{{$r4->typer4->name ?? ''}}" type="text" name="type" class="form-control" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="serial_number">Matricola</label>
            <input value="{{$r4->serial_number}}" type="text" name="serial_number" class="form-control" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="assigned_to">Assegnato a</label>
            <input value="{{$r4->assigned_to}}" type="text" name="assigned_to" class="form-control text-uppercase" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="control_frequency">Frequenza Controllo</label>
            <input value="{{$r4->control_frequency}}" type="text" name="control_frequency" class="form-control text-uppercase" readonly>
        </div>
        
        <div class="col-12 col-md-4">
            <label for="buy_date">Data Acquisto</label>
            <input type="date" value="{{$r4->buy_date}}" name="buy_date" class="form-control" readonly>
        </div>
        
        <div class="col-12 col-md-12">
            <label for="description">Descrizione</label>
            <textarea name="description" class="form-control w-100" rows="4" style="resize: none;" readonly>{{ $r4->description }}</textarea>
        </div>
        
    </div>
    
</x-Layouts.layoutDash>

<style>
    .form-control:focus{
        border-color: #dee2e6;
        box-shadow: none;
    }

    .form-control{
        cursor: default;
    }
</style>

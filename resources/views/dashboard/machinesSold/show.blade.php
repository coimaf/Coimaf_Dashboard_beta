    <x-Layouts.layoutDash>
        
        <div class="row justify-content-end">
            <div class="col-3 no-print">
                <a href="{{ route('dashboard.machinesSolds.edit', $machine->id) }}" class="btn btn-warning float-end fs-4 m-4">Modifica</a>
            </div>
        </div>
        
        <div class="p-3 row g-3">
            
            <div class="col-12">
                <label class="fs-5 mb-1 fw-semibold">Modello</label>
                <input value="{{$machine->model}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Marca</label>
                <input value="{{$machine->brand}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Numero di Serie</label>
                <input value="{{$machine->serial_number}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Vecchio Proprietario</label>
                <input value="{{$machine->old_buyer}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Proprietario Attuale</label>
                <input value="{{$machine->buyer}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Tipo di garanzia</label>
                <input value="{{$machine->warrantyType->name}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Scadenza garanzia</label>
                <input value="{{ \Carbon\Carbon::parse($machine->warranty_expiration_date)->format('d/m/Y') }}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Data installazione</label>
                <input value="{{ \Carbon\Carbon::parse($machine->sale_date)->format('d-m-Y' )}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Registrata il</label>
                <input value="{{ \Carbon\Carbon::parse($machine->registration_date)->format('d-m-Y' )}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Documento di trasporto</label>
                <input value="{{$machine->delivery_ddt}}" class="form-control form-custom fs-5" readonly>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="fs-5 mb-1 fw-semibold">Note</label>
                <textarea class="form-control form-custom fs-5" style="height: 100px; resize: none;" readonly>{{$machine->notes}}</textarea>
            </div>
            
        </div>
        <p class="card-footer fw-semibold mt-3">Creato da: {{$machine->user->name}}  il: {{$machine->created_at->format('d/m/Y')}} 
            @if($machine->updated_by)
            <br><br>Modificato da: {{$machine->updated_by}} il: {{$machine->updated_at->format('d/m/Y')}}</p>
            @endif
    </x-Layouts.layoutDash>
    
    <style>
        .form-custom{
            cursor: default;
        }
        
        .form-custom:hover, .form-custom:focus{
            box-shadow: none;
            border-color: var(--bs-border-color);
        }
        
    </style>
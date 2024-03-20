<x-Layouts.layoutDash>
    <h6 class="fw-bold px-4 pt-4 fs-5">Modifica Dipendente</h6>

    <x-allert />
    
    <form id="form" style="overflow: hidden;" action="{{ route('dashboard.employees.update', ['employee' => $employee->id]) }}" method="post" class="p-4" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Utilizza il metodo PUT per l'aggiornamento -->
        
        <div class="row g-3">
            <div class="col-6">
                <label class="my-2" for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
            </div>
            
            <div class="col-6">
                <label class="my-2" for="surname">Cognome</label>
                <input type="text" name="surname" class="form-control" value="{{ $employee->surname }}" required>
            </div>
            
            <div class="col-12">
                <label class="my-2" for="fiscal_code">Codice Fiscale</label>
                <input type="text" name="fiscal_code" class="form-control text-uppercase" value="{{ $employee->fiscal_code }}" required>
            </div>
            
            <div class="col-6">
                <label class="my-2" for="phone">Cellulare</label>
                <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
            </div>
            
            <div class="col-6">
                <label class="my-2" for="address">Indirizzo</label>
                <input type="text" name="address" class="form-control" value="{{ $employee->address }}">
            </div>
            
            <div class="col-6">
                <label class="my-2" for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $employee->email }}" required>
            </div>
            
            <div class="col-6">
                <label class="my-2" for="email_work">Email Lavoro</label>
                <input type="text" name="email_work" class="form-control" value="{{ $employee->email_work }}">
            </div>
      
            <div class="col-6">
                <label class="my-2" for="birthday">Data di nascita</label>
                <input type="date" name="birthday" class="form-control" value="{{ $employee->birthday }}">
            </div>
            
            <div class="col-12 col-md-6 d-flex align-items-center">
                @foreach($employee->roles as $role)
                <label>Ruolo: </label>
                <label class="fw-bold ps-1"> {{ $role->name }}</label>
                @endforeach
            </div>
            
            
            <div class="row g-3 rounded-5" id="documentFields" style="background-color: rgb(209, 209, 209)">
                <!-- Visualizza e consente la modifica dei documenti associati -->
                @foreach ($employee->documents as $key => $document)
                <div class="col-12 col-md-6 dynamic-element">
                    <h6 class="fw-bold py-3">Documenti</h6>
                    <label for="{{ $document->name }}">{{ $document->name }}</label>
                    <input type="hidden" name="document_names[{{ $key }}]" value="{{ $document->name }}">
                    <input type="file" name="documentEmployees[{{ $key }}][pdf]" class="form-control my-3" accept=".pdf">
                    <input type="date" name="expiry_dates[{{ $key }}]" class="form-control my-3" value="{{ $document->pivot->expiry_date }}" required>
                    <input type="hidden" name="document_ids[{{ $key }}]" value="{{ $document->id }}">
                </div>
                @endforeach
            </div>                            
            
            
            <div class="row py-3">
                @error('documentEmployees.*')
                <div class="alert alert-danger my-2">{{ $message }}</div>
                @enderror
                <x-Buttons.buttonBlue type="submit" props="Salva" />
            </div>
        </div>
    </form>
    
    <style>
        .dynamic-element {
            margin-bottom: 40px; /* Aggiungi il margine desiderato */
        }
    </style>
    
</x-Layouts.layoutDash>

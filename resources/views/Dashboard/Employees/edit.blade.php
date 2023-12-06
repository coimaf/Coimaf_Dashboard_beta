<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Modifica Dipendente</h2>
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <form action="{{ route('dashboard.employees.update', ['employee' => $employee->id]) }}" method="post" class="my-5" enctype="multipart/form-data">
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
                            
                            <div class="col-6">
                                <label class="my-2" for="fiscal_code">Codice Fiscale</label>
                                <input type="text" name="fiscal_code" class="form-control text-uppercase" value="{{ $employee->fiscal_code }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="birthday">Data di nascita</label>
                                <input type="date" name="birthday" class="form-control" value="{{ $employee->birthday }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="phone">Cellulare</label>
                                <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="address">Indirizzo</label>
                                <input type="text" name="address" class="form-control" value="{{ $employee->address }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="email">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $employee->email }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="email_work">Email Lavoro</label>
                                <input type="text" name="email_work" class="form-control" value="{{ $employee->email_work }}" required>
                            </div>
                            
                            <div class="col-6">
                                <label class="my-2" for="role">Ruolo</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="{{ $employee->role }}" selected>{{ $employee->role }}</option>
                                    @foreach ($roles as $role)
                                    @if ($role !== $employee->role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Document Information -->
                            <div class="row g-3 rounded-5 my-4" id="documentFields" style="background-color: rgb(209, 209, 209)">
                                <h4 class="m-0 py-3 ps-4">Documenti</h4>
                                
                                @foreach ($employee->documents as $key => $document)
                                <div class="col-6 dynamic-element">
                                    <input type="hidden" name="documents[{{ $key }}][name]" value="{{ $document->name }}">
                                    
                                    <!-- Visualizza il documento PDF esistente -->
                                    {{-- @if ($document->pdf_path)
                                    <a href="{{ asset('storage/' . $document->pdf_path) }}" target="_blank">{{ $document->name }}</a>
                                    @endif --}}
                                    
                                    <h6 class="text-center my-3" for="document_{{ $key }}">{{ $document->name }}</h6>
                                    <input type="file" name="documents[{{ $key }}][pdf]" id="file_{{ $key }}" class="form-control my-3" accept=".pdf">
                                    
                                    <label class="my-2" for="expiry_date_{{ $key }}">Data di scadenza</label>
                                    <input type="date" name="documents[{{ $key }}][expiry_date]" id="expiry_date_{{ $key }}" class="form-control" value="{{ \Carbon\Carbon::parse($document->expiry_date)->format('Y-m-d') }}">
                                </div>
                                @endforeach
                            </div>
                            
                            <x-Buttons.buttonBlue type="submit" props="Aggiorna" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .dynamic-element {
            margin-bottom: 40px; /* Aggiungi il margine desiderato */
        }
    </style>
    
</x-Layouts.layoutDash>

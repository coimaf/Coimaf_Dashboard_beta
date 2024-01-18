<x-Layouts.layoutDash>
    <h6 class="fw-bold">Aggiungi Dipendente</h6>
    
    <form action="{{ route('dashboard.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <input placeholder="Nome*" type="text" name="name" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Cognome*" type="text" name="surname" class="form-control" required>
            </div>
            
            <div class="col-12">
                <input placeholder="Codice Fiscale*" type="text" name="fiscal_code" class="form-control text-uppercase" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Cellulare" type="text" name="phone" class="form-control">
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Indirizzo" type="text" name="address" class="form-control">
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Email*" type="text" name="email" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <input placeholder="Email Lavoro" type="text" name="email_work" class="form-control">
            </div>

            <div class="col-12 col-md-6">
                <label class="my-2" for="birthday">Data di nascita</label>
                <input type="date" name="birthday" class="form-control" required>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="role">Ruolo</label>
                <select name="role" class="form-control" required>
                    <option value="">Seleziona un ruolo</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Aggiungi questa parte per i documenti dinamici -->
            <div class="row g-3" id="documentFields" style="background-color: rgb(209, 209, 209)">
                <!-- Questa sezione verrà popolata dinamicamente dal JavaScript -->
            </div>
            
            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
        </div>
    </form>
    <style>
        
        @media (max-width: 991.98px) {
            .container-create{
                padding: 10px!important;   
            }
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('[name="role"]').change(function () {
                var roleId = $(this).val();
                var roles = @json($roles);
                
                // Trova il ruolo corrispondente all'ID
                var role = roles.find(r => r.id == roleId);
                
                console.log('Role ID:', roleId);
                console.log('Role:', role);
                
                // Assicurati che il ruolo sia definito prima di accedere ai documenti
                var documents = role ? role.documents : [];
                
                console.log('Documents:', documents);
                
                var html = '<h6 class="m-0 pt-1 fw-bold">Documenti</h6>';
                
                for (var i = 0; i < documents.length; i++) {
                    var defaultName = documents[i].name;
                    
                    html += '<div class="col-12 col-md-6 dynamic-element">';
                        html += '<label for="' + defaultName + '">' + defaultName + '</label>';
                        html += '<input type="hidden" name="document_names[' + i + ']" value="' + defaultName + '">';
                        html += '<input type="file" name="documents[' + i + ']" class="form-control my-3" required accept=".pdf">';
                        html += '<input type="date" name="expiry_dates[' + i + ']" class="form-control my-3" required>';
                        html += '</div>';
                    }
                    
                    $('#documentFields').html(html);
                });
                
                // Chiamare il change() iniziale per visualizzare i documenti iniziali
                $('[name="role"]').change();
            });
            
            
        </script>
        
        
    </x-Layouts.layoutDash>
    
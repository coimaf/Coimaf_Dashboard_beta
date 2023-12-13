<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Aggiungi un nuovo Dipendente</h2>
                    
                    <form action="{{ route('dashboard.employees.store') }}" method="POST" class="my-5" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="name">Nome</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="surname">Cognome</label>
                                <input type="text" name="surname" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="fiscal_code">Codice Fiscale</label>
                                <input type="text" name="fiscal_code" class="form-control text-uppercase" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="birthday">Data di nascita</label>
                                <input type="date" name="birthday" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="phone">Cellulare</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="address">Indirizzo</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="email">Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="email_work">Email Lavoro</label>
                                <input type="text" name="email_work" class="form-control" required>
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
                            
                            <!-- Document Information -->
                            <div class="row g-3 rounded-5 my-4" id="documentFields" style="background-color: rgb(209, 209, 209)">
                                
                                
                            </div>
                            
                            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
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
                var roleName = $(this).find('option:selected').text();  // Ottieni il nome del ruolo selezionato
                var roleId = $(this).val();  // Aggiungi questa linea per ottenere l'id del ruolo
                
                var documentTypes = @json($documentTypes);
                
                var documentFields = documentTypes[roleName];
                
                if (typeof documentFields === 'undefined') {
                    $('#documentFields').html('');
                    return;
                }
                
                var html = '<h4 class="m-0 py-3 ps-4">Documenti</h4>';
                
                for (var i = 0; i < documentFields.length; i++) {
                    var defaultName = documentFields[i];
                    
                    html += '<div class="col-12 col-md-6 dynamic-element">';
                        html += '<label for="' + defaultName + '">' + defaultName + '</label>';
                        html += '<input class="my-3" type="hidden" name="documents[' + i + '][name]" value="' + defaultName + '">';
                        html += '<input type="file" name="documents[' + i + '][pdf]" class="form-control my-3" required accept=".pdf">';
                        html += '<input type="date" name="documents[' + i + '][expiry_date]" class="form-control my-3" required>';
                        html += '</div>';
                    }
                    
                    $('#documentFields').html(html);
                });
                
                // Chiamare il change() iniziale per visualizzare i documenti iniziali
                $('[name="role"]').change();
            });
            
            
        </script>
        
        
    </x-Layouts.layoutDash>
    
<x-Layouts.layoutDash>
    <div class="container">
        <h2>Create Employee</h2>
        
        <form action="{{ route('dashboard.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="surname">Cognome</label>
                <input type="text" name="surname" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="fiscal_code">Codice Fiscale</label>
                <input type="text" name="fiscal_code" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="birthday">Data di nascita</label>
                <input type="date" name="birthday" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Cellulare</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="address">Indirizzo</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email_work">Email Lavoro</label>
                <input type="text" name="email_work" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="role">Ruolo</label>
                <select id="role" name="role" class="form-control" required>
                    <option selected>Seleziona un Ruolo</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Document Information -->
            <div class="form-group" id="documentFields">
                {{-- <h4>Documents</h4> --}}
                
            </div>
            
            <button type="submit" class="btn btn-primary mt-5">Create Employee</button>
        </form>
    </div>
    
    <style>
        .dynamic-element {
            margin: 30px; /* Aggiungi il margine desiderato */
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#role').change(function() {
                var role = $(this).val();
                var documentTypes = @json($documentTypes);
    
                var documentFields = documentTypes[role];
    
                if (typeof documentFields === 'undefined') {
                    $('#documentFields').html('');
                    return;
                }
    
                var html = '';
                for (var i = 0; i < documentFields.length; i++) {
                    var defaultName = documentFields[i];
    
                    html += '<div class="form-group dynamic-element">';
                    html += '<label for="' + defaultName + '">' + defaultName + '</label>';
                    html += '<input type="hidden" name="documents[' + i + '][name]" value="' + defaultName + '">';
                    html += '<input type="file" name="documents[' + i + '][image]" class="form-control" required>';
                    html += '<input type="date" name="documents[' + i + '][expiry_date]" class="form-control" required>';
                    html += '</div>';
                }
    
                $('#documentFields').html(html);
            });
        });
    </script>
    
        
        
        
    </x-Layouts.layoutDash>
    
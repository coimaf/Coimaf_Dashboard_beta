<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="container d-flex justify-content-center my-2 fixed-top">
                @if (session('success'))
                <div class="alert alert-success mt-1">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger mt-1">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="container">
                <div class="row g-3">
                    <section class="bg-white border border-5 row m-0 mt-2">
                        <h4 class="my-2 fw-bold">Ruoli e Documenti Associati</h4>
                        <div class="col-12 col-md-6 my-3 p-3 border">
                            <h4 class="fw-bold my-2">Aggiungi Ruolo</h4>
                            <form action="{{ route('dashboard.settings.employees.addRole') }}" method="post">
                                @csrf
                                <div class="row p-3">
                                    <label class="p-0 mb-2" for="role_name">Nuovo Ruolo:</label>
                                    <input type="text" name="role_name" id="role_name" class="form-control" required>
                                </div>
                                <div class="row px-3 py-0">
                                    <x-Buttons.buttonBlue type="submit" props="Aggiungi"/>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-6 my-3 p-3 border">
                            
                            <h4 class="fw-bold">Associazione Documento</h2>
                                <form action="{{ route('dashboard.settings.employees.manageDocument') }}" method="post">
                                    @csrf
                                    <div class="row align-items-center p-3">
                                        <div class="col-6">
                                            <label class="p-0 mb-2" for="role_id">Seleziona un ruolo:</label>
                                            <select class="form-control" name="role_id" id="role_id">
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="p-0 mb-2"  for="document_id">Seleziona un documento:</label>
                                            <select name="document_id" id="document_id" class="form-control" required>
                                                @foreach ($documents as $document)
                                                <option value="{{ $document->id }}">{{ $document->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        
                                        <div class="col-6">
                                            <button class=" btn btn-success" type="submit" name="action" value="associate">Associa Documento</button>
                                        </div>
                                        <div class="col-6">
                                            <button class=" btn btn-outline-danger" type="submit" name="action" value="dissociate">Dissocia Documento</button>
                                        </div>
                                    </div>
                                    
                                </form>
                                
                            </div>
                            
                        </section>
                        <section class="bg-white border border-5">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Ruolo</th>
                                            <th>Documenti Associati</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @php $first = true; @endphp
                                                @foreach ($role->documents as $document)
                                                {{ $first ? '' : ' - ' }}{{ $document->name }}
                                                @php $first = false; @endphp
                                                @endforeach
                                            </td>
                                            <td>
                                                <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal{{ $role->id }}"></button>
                                                
                                                <form action="{{route('dashboard.settings.employees.removeRole', ['roleId' => $role->id])}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteRoleModalLabel{{ $role->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-black" id="deleteRoleModalLabel{{ $role->id }}">Conferma eliminazione dipendente</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-black" id="RoleInfoContainer{{ $role->id }}">
                                                                    Sicuro di voler eliminare <b>{{ $role->name }}</b>?<br>Se continui saranno eliminati anche i documenti associati.<br>L'azione sarà irreversibile.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                                    <form action="{{route('dashboard.settings.employees.removeRole', ['roleId' => $role->id])}}" method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                        <section class="bg-white border border-5">
                            <div class="col-12 col-md-12 my-2">
                                <h4 class="fw-bold">Aggiungi Documento</h2>
                                    
                                    <form action="{{ route('dashboard.settings.employees.addDocument') }}" method="post">
                                        @csrf
                                        <div class="row p-3">
                                            <label  class="p-0 mb-2" for="document_name">Nuovo Documento:</label>
                                            <input type="text" name="document_name" id="document_name" class="form-control" required>
                                        </div>
                                        <div class="row px-3 py-0">
                                            <x-Buttons.buttonBlue type="submit" props="Aggiungi"/>
                                        </div>
                                    </form>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </section>
            
            
            <section class="bg-white border border-5 m-1 mt-2">
                
                <div class="col-12">
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->name }}</td>
                                <td>
                                    
                                    
                                    <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deletedocumentModal{{ $document->id }}"></button>
                                    
                                    <form action="{{ route('dashboard.settings.employees.removeDocument', ['documentId' => $document->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <!-- Modal -->
                                        <div class="modal fade" id="deletedocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="deletedocumentModalLabel{{ $document->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-black" id="deletedocumentModalLabel{{ $document->id }}">Conferma eliminazione dipendente</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-black" id="documentInfoContainer{{ $document->id }}">
                                                        Sicuro di voler eliminare <b>{{ $document->name }}</b>?<br>L'azione sarà irreversibile.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                        <form action="{{ route('dashboard.settings.employees.removeDocument', ['documentId' => $document->id]) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger">Elimina</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </section>
                
                
                
                
                
                
            </x-Layouts.layoutDash>
            
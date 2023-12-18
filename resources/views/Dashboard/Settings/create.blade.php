<x-Layouts.layoutDash>
    <div class="container-fluid main-content mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="container d-flex justify-content-center">
                @if (session('success'))
                    <div class="alert alert-success mt-5">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-5">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-3"
                 style="background-color: rgb(243, 243, 243); height: 80vh;">
                <div class="col-12 rounded-2 mt-3" style="max-height: 77vh; overflow-y: scroll">
                    <h2>Ruoli e Documenti Associati</h2>
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
                                    <form action="{{ route('settings.removeRole', ['roleId' => $role->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Rimuovi Ruolo</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <h2>Gestisci Ruolo</h2>

                    <form action="{{ route('settings.addRole') }}" method="post">
                        @csrf
                        <label for="role_name">Nuovo Ruolo:</label>
                        <input type="text" name="role_name" id="role_name" required>
                        <button type="submit">Aggiungi Ruolo</button>
                    </form>

                    <h2>Gestisci Documento</h2>

                    <form action="{{ route('settings.manageDocument') }}" method="post">
                        @csrf
                        <label for="role_id">Seleziona un ruolo:</label>
                        <select name="role_id" id="role_id">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                        <label for="document_id">Seleziona un documento:</label>
                        <select name="document_id" id="document_id">
                            @foreach ($documents as $document)
                                <option value="{{ $document->id }}">{{ $document->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" name="action" value="associate">Associa Documento</button>
                        <button type="submit" name="action" value="dissociate">Dissocia Documento</button>
                    </form>

                    <h2>Gestisci Documento</h2>

                    <form action="{{ route('settings.addDocument') }}" method="post">
                        @csrf
                        <label for="document_name">Nuovo Documento:</label>
                        <input type="text" name="document_name" id="document_name" required>
                        <button type="submit">Aggiungi Documento</button>
                    </form>

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
                                    <form action="{{ route('settings.removeDocument', ['documentId' => $document->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Rimuovi Documento</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-Layouts.layoutDash>

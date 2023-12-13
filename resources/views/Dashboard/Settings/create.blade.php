<x-Layouts.layoutDash>
    <div class="container">
        <h2>Aggiungi Nuovo Tipo di Documento</h2>

        <form method="post" action="{{ route('dashboard.settings.store') }}">
            @csrf

            <input class="form-control" readonly="text" name="role" value="{{ $role }}">

            <div class="form-group">
                <label for="types">Tipi di Documento:</label>
                <input type="text" name="types" class="form-control" placeholder="Inserisci i tipi di documento separati da virgola" required>
            </div>

            <button type="submit" class="btn btn-primary my-3">Salva</button>
        </form>
    </div>
</x-Layouts.layoutDash>

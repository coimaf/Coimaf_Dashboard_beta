<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Modifica R4</h6>
    
    <form id="form" class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.r4.update', compact('r4')) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            
            <div class="col-12 col-md-4">
                <input placeholder="Nome" value="{{$r4->name}}" type="text" name="name" class="form-control">
            </div>
            
            <div class="col-12 col-md-4">
                <select class="form-control" name="type_r4_id" id="type_r4_id">            
                    <option value="">Seleziona tipo</option> <!-- Aggiungi questa opzione per indicare di selezionare un tipo -->
                    @foreach ($typer4 as $type)    
                        <option value="{{ $type->id }}" {{ isset($r4->typer4) && $r4->typer4->name == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>  
                    @endforeach            
                </select>                                              
            </div>
                     
            
            <div class="col-12 col-md-4">
                <input placeholder="Matricola" value="{{$r4->serial_number}}" type="text" name="serial_number" class="form-control">
            </div>
            
            <div class="col-12 col-md-4">
                <input value="{{$r4->assigned_to}}" placeholder="Assegnato a" type="text" name="assigned_to" class="form-control  mt-4 text-uppercase">
            </div>
            
            <div class="col-12 col-md-4">
                <input value="{{$r4->control_frequency}}" placeholder="Frequenza Controllo" type="text" name="control_frequency" class="form-control mt-4 text-uppercase">
            </div>
            
            <div class="col-12 col-md-4">
                <label for="buy_date">Data Acquisto</label>
                <input value="{{$r4->buy_date}}" type="date" name="buy_date" class="form-control">
            </div>
            
            <div class="col-12 col-md-12">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control w-100" rows="4" style="resize: none;">{{ $r4->description }}</textarea>
            </div>
            
            <div class="col-12 bg-white">
                <div id="documents">
                    <h3>Documenti</h3>
                    <!-- Loop attraverso i documenti esistenti per la visualizzazione e modifica -->
                    @foreach ($r4->documents as $key => $document)
                    <div class="document row align-items-center mx-0 p-0 pb-1">
                        <div class="col-12 col-md-3">
                            <label for="">Nome del documento</label>
                            <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento" value="{{ $document->name }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="">File del documento</label>
                            <!-- Aggiungi condizione per mostrare il campo solo se il documento ha un file -->
                            @if ($document->file)
                            <input class="form-control" type="file" name="document_file[]">
                            @else
                            <input class="form-control" type="file" name="document_file[]">
                            @endif
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Esecuzione</label>
                            <input class="form-control" type="date" name="document_date_start[]" value="{{ $document->date_start }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Scadenza</label>
                            <input class="form-control" type="date" name="document_expiry_date[]" value="{{ $document->expiry_date }}">
                        </div>
                        <!-- Aggiungi un campo nascosto per l'ID del documento -->
                        <input type="hidden" name="document_id[]" value="{{ $document->id }}">
                        
                        @endforeach
                        <div class="col-12 col-md-1">
                            <!-- Aggiungi un pulsante per aggiungere un nuovo documento -->
                            <button type="button" class="btn mt-3" onclick="addDocument()"><i class="bi bi-plus-circle fs-3 text-success"></i></button>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="fixed-button row">
            <x-Buttons.buttonBlue type="submit" props="Modifica" />
        </div>
    </form>
    
</x-Layouts.layoutDash>

<style>

.fixed-button {
    margin-top: 100px;
    position: fixed;
    bottom: 0;
    width: 80%;
    z-index: 1000; /* Assicurati che il pulsante sia sopra gli altri elementi */
}

</style>


<script>
    function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}
    // Funzione per aggiungere un nuovo campo documento
    function addDocument() {
        var container = document.getElementById('documents');
        var newDocument = document.createElement('div');
        newDocument.classList.add('document', 'row', 'align-items-center', 'my-5', 'mx-0');
        newDocument.innerHTML = `
        <div class="col-12 col-md-3">
            <label for="">Nome del documento</label>
            <input class="form-control" type="text" name="new_document_name[]" placeholder="Nome del documento" required>
        </div>
        <div class="col-12 col-md-3">
            <label for="">File del documento</label>
            <input class="form-control" type="file" name="new_document_file[]">
        </div>
        <div class="col-12 col-md-2">
            <label for="">Data Esecuzione</label>
            <input class="form-control" type="date" name="new_document_date_start[]">
        </div>
        <div class="col-12 col-md-2">
            <label for="">Data Scadenza</label>
            <input class="form-control" type="date" name="new_document_expiry_date[]">
        </div>
        `;
        container.appendChild(newDocument);
        scrollToBottom();
    }
</script>

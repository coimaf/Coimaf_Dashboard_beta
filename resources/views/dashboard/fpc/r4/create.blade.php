<x-Layouts.layoutDash>
    <h6 class="fw-bold p-4 fs-5">Aggiungi R4</h6>
    
    <form class="px-4 py-3" style="overflow: hidden;" action="{{ route('dashboard.fpc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
                        
            <div class="col-12 col-md-4">
                <input placeholder="Nome" type="text" name="name" class="form-control">
            </div>

            <div class="col-12 col-md-4">
                <select class="form-control" name="type_r4_id" id="type_r4_id">
                    <option value="" selected disabled>Seleziona il tipo</option>
                    @foreach ($typer4 as $type)                  
                    <option value="{{$type->id}}">{{$type->name}}</option>  
                    @endforeach            
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Matricola" type="text" name="serial_number" class="form-control">
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Assegnato a" type="text" name="assigned_to" class="form-control  mt-4 text-uppercase">
            </div>
            
            <div class="col-12 col-md-4">
                <input placeholder="Frequenza Controllo" type="text" name="control_frequency" class="form-control mt-4 text-uppercase">
            </div>

            <div class="col-12 col-md-4">
                <label for="buy_date">Data Acquisto</label>
                <input type="date" name="buy_date" class="form-control">
            </div>

            <div class="col-12 col-md-12">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control w-100" rows="4" style="resize: none;"></textarea>
            </div>
            

            <div>
                <h3 class="my-4">Aggiungi Documenti</h3>
                <div id="documents">
                    <div class="document row align-items-center">
                        <div class="col-12 col-md-3">
                            <label for=""> </label>
                            <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for=""> </label>
                            <input class="form-control" type="file" name="document_file[]">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Esecuzione</label>
                            <input class="form-control" type="date" name="document_date_start[]">
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="">Data Scadenza</label>
                            <input class="form-control" type="date" name="document_expiry_date[]">
                        </div>
                        <div class="col-12 col-md-2 p-0 mt-3">
                            <button class="btn" type="button" onclick="addDocument()"><i class="bi bi-plus-circle fs-3 text-success"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row py-3">
                <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
            </div>
            
        </div>
    </form>
    
</x-Layouts.layoutDash>


<script>
    function addDocument() {
        var container = document.getElementById('documents');
        var newDocument = document.createElement('div');
        newDocument.classList.add('document');
        newDocument.innerHTML = `
        <div class="document row align-items-center my-4">
            <div class="col-12 col-md-3">
                <input class="form-control" type="text" name="document_name[]" placeholder="Nome del documento">
            </div>
            <div class="col-12 col-md-3">
                <input class="form-control" type="file" name="document_file[]">
            </div>
            <div class="col-12 col-md-2">
                <input class="form-control" type="date" name="document_date_start[]">
            </div>
            <div class="col-12 col-md-2">
                <input class="form-control" type="date" name="document_expiry_date[]">
            </div>
        </div>
        `;
        container.appendChild(newDocument);
    }
</script>

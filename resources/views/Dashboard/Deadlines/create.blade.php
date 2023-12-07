<x-Layouts.layoutDash>
    <div class="container-fluid main-content">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-3 mt-5" style="background-color: rgb(243, 243, 243); height: 90vh;">
                <div class="col-12 rounded-2 mt-3 p-5 container-create" style="max-height: 80vh; overflow-y: scroll">
                    <h2 class="">Aggiungi un nuovo Documento</h2>
                    
                    <form action="{{ route('dashboard.deadlines.store') }}" method="POST" class="my-5" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="my-2" for="name">Nome Documento</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="pb-3" for="description">Descrizione</label>
                                <textarea type="text" name="description" class="form-control" style="height: 100px; resize: none;" required></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <strong>Tags:</strong><br>
                                @foreach ($tags as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                        <label class="form-check-label">{{ $tag->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            
                            
                            
                            <div class="col-12 col-md-6 mb-4">
                                <label class="my-2" for="expiry_date">Data di scadenza</label>
                                <input type="date" name="expiry_date" class="form-control" required>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <label class="my-2" for="pdf">Carica Documento</label>
                                <input type="file" name="pdf" accept=".pdf" class="form-control" required>
                            </div>
                            
                            <x-Buttons.buttonBlue type="submit" props="Aggiungi" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    
</x-Layouts.layoutDash>
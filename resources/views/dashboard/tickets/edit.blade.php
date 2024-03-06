<x-Layouts.layoutDash>
    
    <form class="p-4 container" style="overflow: hidden;" action="{{ route('dashboard.tickets.update', $ticket->id) }}" method="POST" class="my-1">
        @csrf
        @method('PUT')
        <h6 class="fw-bold fs-5">Modifica Ticket</h6>
        <div class="row g-2">
            <div class="col-12 col-md-4">
                <label class="my-2" for="title">Titolo</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title) }}" required>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="priority">Priorità</label>
                <select name="priority" class="form-control" required>
                    <option value="">Seleziona una priorità</option>
                    @foreach(\App\Models\Ticket::getPriorityOptions() as $priorityOption)
                    <option value="{{ $priorityOption }}" {{ old('priority', $ticket->priority) == $priorityOption ? 'selected' : '' }}>
                        {{ $priorityOption }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="status">Stato</label>
                <select name="status" class="form-control" required>
                    <option value="">Seleziona uno stato</option>
                    @foreach(\App\Models\Ticket::getStatusOptions() as $statusOption)
                    @if($statusOption !== 'Chiuso')
                    <option value="{{ $statusOption }}" {{ old('status', $ticket->status) == $statusOption ? 'selected' : '' }}>
                        {{ $statusOption }}
                    </option>
                    @elseif($ticket->status === 'Chiuso')
                    <option value="{{ $statusOption }}" selected>
                        {{ $statusOption }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>         
            
            <div class="col-12 col-md-4">
                <label class="pb-3" for="selectedCustomer">Cliente*</label>
                <input type="text" placeholder="Cliente*" list="customer" class="form-control" id="customerInput" name="selectedCustomer" value="{{ $ticket->descrizione }}">
                <input type="hidden" id="selectedCdCFInput" name="selectedCdCF" value="{{ $ticket->cd_cf }}">
                <input type="hidden" id="selectedCd_CFClasse3Input" name="selectedCd_CFClasse3" value="{{ $ticket->Cd_CFClasse3 }}">
                <datalist id="customer" required>
                    @foreach ($customers as $customer)
                    <option value="{{ trim($customer->Descrizione) }}" data-cd-cf="{{ $customer->Cd_CF }}" data-Cd_CFClasse3='{{ $customer->Cd_CFClasse3}}'></option>
                    @endforeach
                </datalist>
            </div>       
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="machine_model_id">Modello Macchina</label>
                <select name="machine_model_id" class="form-control">
                    <option value="">Seleziona un Modello</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}" {{ old('machine_model_id', $ticket->machine_model_id) == $machine->id ? 'selected' : '' }}>
                        {{ $machine->model }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-4">
                <label class="my-2" for="machine_sold_id">Seriale Macchina</label>
                <select name="machine_sold_id" class="form-control">
                    <option value="">Seleziona un Seriale</option>
                    @foreach($machines as $machine)
                    <option value="{{ $machine->id }}" {{ old('machine_sold_id', $ticket->machine_sold_id) == $machine->id ? 'selected' : '' }}>
                        {{ $machine->serial_number }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-12">
                <label class="pb-3" for="description">Descrizione Problema</label>
                <textarea type="text" name="description" class="form-control" style="height: 70px; resize: none;">{{ old('description', $ticket->description) }}</textarea>
            </div>
            
            <div class="col-12 col-md-12">
                <label class="pb-3" for="notes">Risoluzione Problema</label>
                <textarea type="text" name="notes" class="form-control" style="height: 100px; resize: none;" >{{ old('notes', $ticket->notes) }}</textarea>
            </div>
            
            <div class="col-12 col-md-6">
                <label class="my-2" for="technician_id">Tecnico</label>
                <select name="technician_id" class="form-control">
                    <option value="">Seleziona un Tecnico</option>
                    @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}" {{ old('technician_id', $ticket->technician_id) == $technician->id ? 'selected' : '' }}>
                        {{ $technician->name }} {{ $technician->surname }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-5">
                <label class="my-2" for="intervention_date">Data Intervento</label>
                <input type="date" name="intervention_date" class="form-control" value="{{ old('intervention_date', $ticket->intervention_date) }}" >
            </div>
            
            
            <div class="col-12 col-md-1 d-flex justify-content-center align-items-center mt-5">
                <label class="my-2 me-2 fw-bold" for="pagato">PAGATO:</label>
                <input type="checkbox" id="pagato" name="pagato" value="1" @if(old('pagato', $ticket->pagato ?? false)) checked @endif>
            </div> 
            
        </div>
        
        <div class="row py-3">
            <x-Buttons.buttonBlue type="submit" props="Salva" />
        </div>
        
        <div class="row m-3 border rounded-4 p-3 bg-white">
            
            <div class="col-12 col-md-2">
                <label class="pb-3" for="art">Seleziona un articolo</label>
                <input type="text" placeholder="Seleziona un Articolo" list="art" class="form-control" id="articleInput" name="art">
                <input type="hidden" id="selectedArtInput" name="selectedArtInput">
                <datalist id="art">
                    @foreach ($articles as $article)
                    <option value="{{ trim($article->Cd_AR) }}" data-desc="{{ $article->Descrizione }}" data-prezzo="{{ $article->Prezzo }}"></option>
                    @endforeach
                </datalist>
            </div>  
            
            <div class="col-12 col-md-3">
                <label class="pb-3" for="desc">Seleziona una Descrizione</label>
                <input type="text" placeholder="Seleziona una descrizione" list="desc" class="form-control" id="descInput" name="desc">
                <input type="hidden" id="selectedDescInput" name="selectedDescInput">
                <datalist id="desc">
                    @foreach ($articles as $article)
                    <option value="{{ trim($article->Descrizione) }}" data-art="{{ $article->Cd_AR }}" data-prezzo="{{ $article->Prezzo }}"></option>
                    @endforeach
                </datalist>
            </div>            
            
            
            
            <div class="col-12 col-md-1">
                <label class="my-2" for="qnt">Quantità</label>
                <input type="number" id="qnt" name="qnt" class="form-control" value="0">
            </div>
            @php
                $przValue = 0;
            @endphp
            <div class="col-12 col-md-2">
                <label class="my-2" for="prz">Prezzo</label>
                <div class="input-group">
                    <input type="text" name="prz" id="prz" class="form-control" value="{{ number_format($przValue, 2, ',', '.') }}" step="0.01" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            
            <div class="col-12 col-md-1">
                <label class="my-2" for="sconto">Sconto</label>
                <div class="input-group">
                    <input type="text" id="sconto" name="sconto" class="form-control" value="0">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-2">
                <label class="my-2" for="tot">Totale</label>
                <div class="input-group">
                    <input type="text" id="tot" name="tot" class="form-control" value="{{ number_format($przValue, 2, ',', '.') }}" readonly>
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
            </div>
            
            <div class="col-1 d-flex align-items-center" style="padding-top: 24px;">
                <button type="submit" class="btn" id="plusBtn"><i class="bi bi-plus-circle-fill fs-4"></i></button>
            </div>
            
        </div>
        
    </form>
    
    
    <section id="formSection" class="bg-white border border-5 m-1 mt-2">
        
        <div class="col-12">
            <div id="replacementTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Articolo</th>
                            <th>Descrizione</th>
                            <th>Quantità</th>
                            <th class="text-end">Prezzo</th>
                            <th class="text-center">Sconto</th>
                            <th class="text-end">Totale</th>
                            <th class="text-center">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($replacements as $replacement)
                        <tr>
                            <td>{{ $replacement->art }}</td>
                            <td>{{ $replacement->desc }}</td>
                            <td class="text-center" width='10px;'>{{ $replacement->qnt }}</td>
                            <td class="text-end" width='100px;'>{{ number_format($replacement->prz, 3, ',', '.') }}</td>
                            <td class="text-center" width='80px;'>{{ $replacement->sconto }}%</td>
                            <td class="text-end total" width='80px;'>{{ number_format($replacement->tot, 3, ',', '.') }}</td>
                            <td class="text-center">
                                
                                
                                <button type="button" class="btn bi bi-trash3-fill text-danger" data-bs-toggle="modal" data-bs-target="#deletereplacementModal{{ $replacement->id }}"></button>
                                
                                <form action="{{ route('dashboard.replacements.destroy', $replacement->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <!-- Modal -->
                                    <div class="modal fade" id="deletereplacementModal{{ $replacement->id }}" tabindex="-1" aria-labelledby="deletereplacementModalLabel{{ $replacement->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-black" id="deletereplacementModalLabel{{ $replacement->id }}">Conferma eliminazione dipendente</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-black" id="replacementInfoContainer{{ $replacement->id }}">
                                                    Sicuro di voler eliminare <b>{{ $replacement->art }}</b>?<br>L'azione sarà irreversibile.
                                                </div>
                                                <div class="modal-body text-danger fw-bold" id="replacementInfoContainer{{ $replacement->id }}">
                                                    RICORDA DI AGGIORNARE I DATI MANUALMENTE SU ARCA! <br>Al momento non è prevista una funzione di eliminazione automatica.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                                    <form action="{{ route('dashboard.replacements.destroy', $replacement->id) }}" method="post">
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
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Totale:</td>
                                <td class="text-end fw-bold" id="totalCell"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Iva:</td>
                                <td class="text-end fw-bold" id="iva"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">A Pagare:</td>
                                <td class="text-end fw-bold" id="aPagare"></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </section>
        
        
    </x-Layouts.layoutDash>
    
    <script>
        
        
        document.addEventListener('DOMContentLoaded', function() {
            // Seleziona il campo dello stato
            const statusField = document.querySelector('select[name="status"]');
            let statoIniziale = statusField.value;
            // Seleziona tutti gli input e select nel modulo
            const formControls = document.querySelectorAll('form input, form select, form textarea');
            // Seleziona il campo della data di intervento
            const interventionDateField = document.querySelector('input[name="intervention_date"]');
            // Seleziona il campo seleziona un articolo
            const articleInput = document.querySelector('#articleInput');
            
            // Funzione per impostare lo stato dei campi del modulo
            function setFormControlsState(disabled) {
                // Itera su tutti gli input e select nel modulo
                formControls.forEach(function(control) {
                    // Escludi il campo dello stato stesso
                    if (control !== statusField) {
                        // Imposta lo stato di readonly/disabled per gli input e select
                        control.disabled = disabled;
                    }
                });
                // Verifica se lo stato selezionato è "Da fatturare"
                if (statusField.value === 'Da fatturare') {
                    // Imposta il campo della data di intervento come obbligatorio
                    interventionDateField.required = true;
                } else {
                    // Rimuovi l'attributo required dal campo della data di intervento
                    interventionDateField.removeAttribute('required');
                }
            }
            
            // Funzione per controllare se la lista degli articoli è vuota
            function isArticleListEmpty() {
                const articleList = document.querySelectorAll('#art option');
                return articleList.length === 0;
            }
            
            // Funzione per impostare lo stato dei campi del modulo
            function setFormControlsState(disabled) {
                // Itera su tutti gli input e select nel modulo
                formControls.forEach(function(control) {
                    // Escludi il campo dello stato stesso
                    if (control !== statusField) {
                        // Imposta lo stato di readonly/disabled per gli input e select
                        control.disabled = disabled;
                    }
                });
                // Verifica se lo stato selezionato è "Da fatturare"
                if (statusField.value === 'Da fatturare') {
                    // Imposta il campo della data di intervento come obbligatorio
                    interventionDateField.required = true;
                    // Controlla se la lista degli articoli è vuota
                    if (isArticleListEmpty()) {
                        articleInput.required = true;
                    }
                } else {
                    // Rimuovi l'attributo required dal campo della data di intervento
                    interventionDateField.removeAttribute('required');
                    articleInput.removeAttribute('required');
                }
            }
            
            
            // Verifica lo stato iniziale al caricamento della pagina
            if (statoIniziale === 'Chiuso') {
                // Imposta tutti i campi del modulo come readonly/disabled
                setFormControlsState(true);
            }
            
            // Aggiungi un evento onchange al campo dello stato
            statusField.addEventListener('change', function() {
                // Verifica se lo stato selezionato è "Chiuso"
                if (this.value === 'Chiuso') {
                    // Imposta tutti i campi del modulo come readonly/disabled
                    setFormControlsState(true);
                } else {
                    // Riattiva tutti i campi del modulo
                    setFormControlsState(false);
                }
            });
            
            
        });
    </script>
    
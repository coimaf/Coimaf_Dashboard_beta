### 13/03/2024

## Generali
- [x] Aggiunta leggenda icone;
- [x] Aumentata la dimensione dei button;

## Macchine Installate
- [x] Ricerca tramite Codice articolo con campi autocompilati Marca e Modello (Descrizione);
- [x] 'Registrata il' rimosso, si puo risalire in base a chi lo ha creato conrtollando la data;
- [x] Immagine mostrata solo se esiste;

### 18/03/2024 - 19/03/2024 - 20/03/2024

## Generali
- [x] In tutte le pagine va inserito un refresh di 1 ora per evitare che permangano su dati obsoleti;
- [ ] Quando inserisco o modifico e cambio pagina, prima di uscire inserire un alert "stai uscendo senza salvare, continuare?";

## Ticket
- [ ] Dobbiamo rilevare un flag di "bloccato"; (aspettare francesco per la query)
- [x] Il saldo va formattato con , per i centesimi e i . per le migliaia;
- [x] La index deve avere titolo - cliente - stato - priorita - data - zona - saldo;
- [x] Togliere la colonna elimina dalla lista dei ticket;
- [x] In ticket quando seleziono il modello macchina dal db macchine la lista che mi appare deve essere filtrata solo con le macchine assegnate al cliente inserito nella casella cliente altrimenti la selezione è impossibile;
- [x] Se il ticket e' chiuso nella index deve apparire in rosso;
- [x] Prima cliente e poi titolo in ticket index;
- [x] Ordine decrescente e 'chiusi' alla fine;
- [x] Sfondo grigio a Chiuso, e 'urgente' in rosso;

## Macchine Installate
- [x] Nella index del db macchine togliere la colonna elimina;
- [x] Codice articolo diventa modello e Modello diventa descrizione;
- [x] Mettere nella index numero di serie e modello;

## Sottoscorta
- [ ] In sottoscorta le colonne con i numeri devono avere tutte la stessa larghezza;

## Listini
- [x] Nei listini, nella lista mettiamo anche il prezzo del listino 1, del listino 8+sconto e del listino 9 come colonne;
- [x] Risolto bug listini per la formattazione;
- [x] Risolto bug listini per articoli contenenti caratte come ABC/D;
- [x] Risolto bug se Sconto e NULL;
- [x] Aggiungere marca alla index;
- [x] Sconto formattato con Sc;
- [x] Prezzi Listini allineati a destra;

### IMPORTANTE
- [ ] Ticket soluzione in note;
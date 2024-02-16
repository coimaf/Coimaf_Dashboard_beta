# Dashboard COIMAF

![alt text](https://github.com/NicolaMazzaferro/Coimaf_Dashboard_beta/blob/main/public/assets/coimaf_logo.png?raw=true)

Dashboard su rete locale per gestione dipendenti, documenti ecc... con sistema di Autenticazione ActiveDirectory e protocolli LDAP.
Il Database non sincronizza le password, in caso di mancata connessione con il server ActiveDirectory gli utenti non potranno Autenticarsi.
La gestione dei ruoli dipende da ActiveDirectory.

## Installazione
```
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```
## Configurazione
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

```
LDAP_LOGGING=true
LDAP_CONNECTION=default
LDAP_CONNECTIONS=default

LDAP_DEFAULT_HOSTS=192.168.1.47
LDAP_DEFAULT_USERNAME="cn=utente test,cn=Users,dc=azienda,dc=lan"
LDAP_DEFAULT_PASSWORD=SuperSecret1!
LDAP_DEFAULT_PORT=389
LDAP_DEFAULT_BASE_DN="dc=azienda,dc=lan"
LDAP_DEFAULT_TIMEOUT=5
LDAP_DEFAULT_SSL=false
LDAP_DEFAULT_TLS=false
LDAP_DEFAULT_SASL=false
```

## Lancia il progetto
```
php artisan serve
npm run dev
```

## Test
```
php artisan ldap:test
php artisan ldap:browse
```

## ToDo
### Configurazione Progetto
- [x] Configurazione Bootstrap
- [x] Building Asset
- [x] Configurazione Layout e Componenti
- [x] Configurazione Database

### Autenticazione
- [x] Installazione LdapRecord
- [x] Configurazione LdapRecord
- [x] Installazione Fortify
- [x] Configurazione Fortify
- [x] Configurazione Fortify <-> LdapRecord

### Permessi
- [x] Importazione Ruoli da AD
- [x] Conversione dei Ruoli nel Database
- [x] Creato Middleware Custom per 'Officina'
- [x] Gestione errori 403 - 404

### Dipendenti
 - [x] Ogni dipendente deve avere un nome, un cognome e un ruolo;
 - [x] Ogni dipendente deve avere una lista di documenti;
 - [x] Ogni documento deve avere un nome, un file PDF e una scadenza;
 - [x] Quando creo un dipendente voglio avere un form con i campi:
    - [x] nome - cognome;
    - [x] ruolo: [Ufficio, Operaio, Canalista, Frigorista];
     - [x] quando seleziono il ruolo deve comparire la lista dei nomi dei documenti relativi a quel ruolo, dove posso caricare l'immagine del documento e selezionare la data di scadenza;

- [x] Modifica i dati di un Dipendete esistente;
- [x] Visualizza i dati principali di ogni dipendente nella tabella;
- [x] Visualizza i Documenti scaduti e in scadenza nella tabella tramite icona e tooltip;
- [x] Visualizza i dettagli del singolo dipendente;
- [x] Download dei documenti di ogni dipendente;
- [x] Conferma prima di eliminare un dipendente;
- [x] Elimina un dipendente;

### Scadenzario
- [x] Ogni Documento deve avere un Nome, una Descrizione e dai Tag;
- [x] Ogni Documento deve avere un file PDF e una Scadenza;
- [x] Quando creo un documento in scadenza voglio avere un form con i campi:
    - [x] nome - descrizione - Tag - Scadenza - e la possibilità di caricare il pdf;
    - [x] i tag possono essere più di uno;
- [x] Modifica i dati di un Documento esistente;
- [x] Visualizza i dati principali di un documento nella tabella;
- [x] Visualizza i Documenti scaduti e in scadenza nella tabella tramite icona e tooltip;
- [x] Visualizza i dettagli del singolo documento;
- [x] Download dei documenti;
- [x] Conferma prima di eliminare un documento;
- [x] Elimina un documento;

### Profilo
- [x] Visualizzare informazioni Profilo;
- [x] Cambio e-mail da ".lan" a ".com";

### Impostazioni
- [x] Aggiungere o rimuovere Ruoli ai Dipendenti;
- [x] Aggiungere o rimuovere Documenti ai Dipendenti;
- [x] Associa o dissocia Ruoli ai Dipendenti;
- [x] Associa o dissocia Documenti ai Ruoli;
- [x] Aggiungere o rimuovere Tags per lo scadenzario;

### Arca
- [x] Installizione msphpsql ( MicrosoftSQL );
- [x] Configurazione Arca;
- [x] Ricevi dati da Arca;

### Macchine Vendute (Implementazione ARCA)
- [x] Tutte le macchine vendute devono avere:
    - [x] Modello;
    - [x] Marca (menu a tendina) da ARCA;
    - [x] Numero Serie;
    - [x] Data Vendita;
    - [x] Primo Acquirente da ARCA;
    - [x] Propietario attuale da ARCA;
    - [x] Data scadenza garanzia;
    - [x] Tipo Garanzia (menu a tendina config da impostazioni);
    - [x] Data Registrazione;
    - [x] DDT Consegna;
    - [x] Note;
- [x] Crea;
- [x] Modifica;
- [x] Salva Modifiche;
- [x] Visualizza;
- [x] Visualizza Dettaglio;
- [x] Elimina;
- [x] Indicizza per la ricerca;

### Ticket
- [x] Oggetto ticket - mandatario;
- [x] Descrizione del problema (textarea) - mandatario;
- [x] Cliente (nome) obbligatorio, compilato se selezionato da elenco, con ricerca da ARCA;
- [x] Cliente (codice) - compilato da ARCA;
- [x] Numero del ticket - compilato incrementalmente;
- [x] Macchina (descrizione) selezione dal db delle macchine, compilato;
- [x] Numero di serie macchina selezione dal db delle macchine, compilato;
- [x] Data apertura - compilata;
- [x] Data risoluzione - selezionabile da calendario;
- [x] Stato: 
    Aperto - in lavorazione - in attesa di un ricambio - da fatturare - chiuso;
- [x] Priorità: 
    Bassa - Normale - Urgente;
- [x] Tecnico incaricato - Configurabile da impostazioni;
- [x] Risoluzione del problema - (text area);
- [x] Crea;
- [x] Modifica;
- [x] Salva Modifiche;
- [x] Visualizza;
- [x] Visualizza Dettaglio;
- [x] Elimina;
- [x] Indicizza per la ricerca;
- [x] Stampa Ticket con impaginazione dedicata;
- [x] Invia email di avviso ogni nuovo ticket;

### Articoli Sotto Scorta
- [x] Crea index per articoli sotto scorta;
- [x] Ricevi articoli sotto scorta da arca;
- [x] Ottimizza query per visualizzare gli articoli sotto scorta;
- [x] Filtra per nome articoli sotto scorta;
- [x] Filtra per prezzo articoli sotto scorta;
- [x] Ricerca articoli sotto scorta;

### Flotta
- [x] Crea in impostazioni la possibilita di gestire il tipo di veicolo ( auto - furgone ecc...);
- [x] Crea CRUD per Flotta;
- [x] Associa documenti a Flotta;
- [x] Gestisci documenti per flotta in impostazioni;
- [x] Aggiungi i documenti associati a flotta nel CRUD di Flottta;
    - [x] Create;
    - [x] Store;
    - [x] Edit;
    - [x] Update;
    - [x] Show;
    - [x] Index;
- [x] Collega le manutenzion ai veicoli di flotta;
- [x] Possibilita di aggiungere le manutenzioni solo in fase di modifica di un veicolo;
    - [x] Edit;
    - [x] Update;
    - [x] Show;
- [x] Filtra;
- [x] Cerca;

### Homepage
- [x] Mostra i ticket aperti - in attesa di ricambio - urgenti.
- [x] Mostra le scadenze di scadenzario in scadenza - scaduti.
- [x] Mostra Articoli Sotto Scorta;
- [x] Mostra Scadenze Flotta;



### Funzioni generali
- [x] Filtri;
- [x] Searchbar Generale;
- [x] Searchbar Dedicata ai modelli;
- [x] Ogni elemento creato deve avere associato l'utente che lo ha creato;
- [x] Invio Mail di Avviso Scadenza;
 - [x] Aggiungi env con dati email mittente:
 - [x] Definire logica invio email;
 - [x] Definire destinatario;
 - [x] * * * * * cd /percorso-del-tuo-progetto && php artisan schedule:run >> /dev/null 2>&1 comando per inviare mail ogni giorno dal server;
- [x] Utente Admin Persistente nel DB (in caso AD è down);

### *********** Bug ***********
- [x] Visualizzo tutti i profili e non solo quello Loggato;
- [x] Ricevo solo l'ultimo gruppo di memberOf anzichè tutti;
- [x] Validazione e modifica documenti Dipendenti;
- [x] Indicizzazione Ricerca dei modelli associati;
- [x] Controllare le relazioni con arca in machines_sold e Tickets
- [x] Utente persistente non funziona con Guards diversa da web
- [x] Updatedby non funziona nelle notifiche di employee
- [x] Cambiare email e DB fittizio dal controller Ticket in create e store;
- [ ] Testare le mail operativo e assistenza in ticket - deadline - employee
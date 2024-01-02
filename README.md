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

### Macchine Vendute (Implementazione ARCA)
- [ ] Tutte le macchine vendute devono avere:
    - [x] Modello;
    - [ ] Marca (menu a tendina) da ARCA;
    - [x] Numero Serie;
    - [x] Data Vendita;
    - [ ] Primo Acquirente da ARCA;
    - [ ] Propietario attuale da ARCA;
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

### Funzioni generali
- [x] Filtri;
- [x] Searchbar;
- [x] Ogni elemento creato deve avere associato l'utente che lo ha creato;
- [ ] Invio Mail di Avviso Scadenza;
- [ ] Utente Admin Persistente nel DB (in caso AD è down);

### *********** Bug ***********
- [ ] Validazione e modifica documenti Dipendenti;
- [ ] Indicizzazione Ricerca dei modelli associati;
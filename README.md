# Dashboard COIMAF
Dashboard su rete locale per gestione dipendenti, documenti ecc... con sistema di Autenticazione ActiveDirectory e protocolli LDAP.
Il Database non sincronizza le password, in caso di mancata connessione con il server ActiveDirectory gli utenti non potranno Autenticarsi.
La gestione dei ruoli dipende da ActiveDirectory.

## ToDo
### Configurazione Progetto
[x] Configurazione Bootstrap
[x] Building Asset
[x] Configurazione Layout e Componenti
[x] Configurazione Database

### Autenticazione
[x] Installazione LdapRecord
[x] Configurazione LdapRecord
[x] Installazione Fortify
[x] Configurazione Fortify
[x] Configurazione Fortify <-> LdapRecord

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
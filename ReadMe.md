# AlMarconi

**Piattaforma online per la connessione tra diplomati dell’ITI G. Marconi Pontedera e il mondo del lavoro.**  
Progetto sviluppato da: **Bassoni Tommaso, Lombardi Mattia, Mosti Filippo**  

---

## 🎯 Obiettivo del progetto

Il progetto **AlMarconi** ha lo scopo di creare una piattaforma online che raccolga e metta in contatto domanda e offerta di lavoro tra ex studenti dell’**ITI G. Marconi di Pontedera** e le aziende del territorio.

---

## 🧰 Modalità di utilizzo

### 🔗 Accesso online (se disponibile)
Basta digitare l'URL dedicato nel browser (sarà fornito al momento della pubblicazione).

### 🖥️ Utilizzo locale
1. Scaricare la cartella del progetto da GitHub.
2. Installare [XAMPP](https://www.apachefriends.org/index.html).
3. Copiare il progetto nella cartella `htdocs` di XAMPP.
4. Avviare **Apache** e **MySQL** dal pannello XAMPP.
5. Aprire il browser e digitare `http://localhost/AlMarconi/WebPage/index.html` per utilizzare l'app localmente.

---

## 🏗️ Architettura del sistema

### 🔹 Front-End
- HTML e JavaScript per l’interfaccia utente.
- Comunicazione con i web services tramite chiamate RPC HTTP.
- Visualizzazione dinamica con script lato client.

### 🔸 Back-End
- Web Services in architettura **SOA (Service-Oriented Architecture)**.
- Servizi RESTful indipendenti.
- Tutti i servizi rispondono in formato **JSON**.

---

## 📡 Web Services attualmente implementati

| Endpoint       | Metodo | Descrizione                    |
|----------------|--------|--------------------------------|
| `/login`       | POST   | Login con email e password     |
| `/login/otp`   | POST   | Verifica OTP                   |
| `/logout`      | POST   | Logout utente                  |
| `/account`     | POST   | Creazione nuovo account        |
| `/account`     | DELETE | Eliminazione account           |

---

## 🌐 Elenco Web Services

| Endpoint                        | Metodo | Descrizione                              | Input                                                                                      | Output                                                                                     |
|---------------------------------|--------|------------------------------------------|---------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------|
| `/login`                        | POST   | Login utente                             | `email` (string), `password` (string)                                                       | `id` (num), `verificato` (bool), `tipo` (string), `nome` (string), `otpRequired` (bool)    |
| `/login/otp`                    | POST   | Verifica codice OTP                      | `otp` (num)                                                                                 | `id` (num), `verificato` (bool), `tipo` (string), `nome` (string)                          |
| `/logout`                       | POST   | Logout utente                            | –                                                                                           | `logout` (bool)                                                                            |
| `/account`                      | POST   | Creazione account                        | Vari campi anagrafici (vedi dettagli sotto)                                                 | `id` (num), `verificato` (bool)                                                            |
| `/account`                      | DELETE | Eliminazione account                     | `password` (string)                                                                         | `delete` (bool)                                                                            |
| `/account/{id}`                 | GET    | Visualizzazione dati profilo             | –                                                                                           | Tutti i dati anagrafici e aziendali (vedi specifica)                                       |
| `/account/{id}`                 | PATCH  | Modifica parziale del profilo            | Campi da aggiornare in array `data[]`                                                       | Nessun output specifico (successo implicito)                                               |
| `/annuncio`                     | POST   | Creazione di un annuncio                 | Dati annuncio (non specificati)                                                             | Dati annuncio creato o conferma creazione                                                  |
| `/annuncio`                     | GET    | Elenco annunci                           | –                                                                                           | Lista annunci (array JSON)                                                                 |
| `/annuncio/{id}`                | GET    | Visualizzazione dettaglio annuncio       | –                                                                                           | Dati specifici dell'annuncio                                                               |
| `/annuncio/{id}`                | PATCH  | Modifica annuncio                        | Campi modificabili dell'annuncio                                                            | Esito aggiornamento                                                                        |
| `/annuncio/{id}`                | DELETE | Eliminazione annuncio                    | –                                                                                           | Conferma eliminazione                                                                      |
| `/citta`                        | GET    | Elenco città disponibili                 | –                                                                                           | Lista città (array stringhe)                                                               |
| `/account/{id}/sede`            | POST   | Aggiunta sede aziendale                  | `citta`, `via`, `civico`                                                                    | Conferma inserimento sede                                                                  |
| `/account/{id}/sede`            | GET    | Elenco sedi aziendali dell’account       | –                                                                                           | Lista sedi (array JSON)                                                                    |
| `/account/{id}/sede/{id}`       | GET    | Visualizzazione sede specifica           | –                                                                                           | Dati sede specifica                                                                        |
| `/account/{id}/sede/{id}`       | PATCH  | Modifica sede                            | Campi da aggiornare                                                                         | Esito aggiornamento                                                                        |
| `/account/{id}/sede/{id}`       | DELETE | Eliminazione sede                        | –                                                                                           | Conferma eliminazione                                                                      |
| `/account/{id}/competenze`      | POST   | Aggiunta competenza                      | `descrizione`, `livello`, `categoria`, ecc. (da definire)                                  | Conferma inserimento                                                                       |
| `/account/{id}/competenze`      | GET    | Elenco competenze                        | –                                                                                           | Lista competenze                                                                           |
| `/account/{id}/competenze/{id}` | GET    | Visualizzazione competenza specifica     | –                                                                                           | Dettagli competenza                                                                        |
| `/account/{id}/competenze/{id}` | PATCH  | Modifica competenza                      | Campi da aggiornare                                                                         | Esito aggiornamento                                                                        |
| `/account/{id}/competenze/{id}` | DELETE | Eliminazione competenza                  | –                                                                                           | Conferma eliminazione                                                                      |

---

## 🧪 Funzionalità disponibili al termine del progetto

- Registrazione e autenticazione utenti.
- Accesso alla Home Page della piattaforma.
- Consultazione annunci e gestione profili (una volta implementati).

---

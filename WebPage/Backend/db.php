<?php	//Per connettersi al database
$host = 'localhost';
$dbname = 'AlMarconi';
$username = 'root';
$password = '';

// Avvio della connessione
$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_errno) {
	die('Connessione non riuscita: ' . $conn->connect_error);
}

$conn->set_charset('utf8');

/**  
 * @param Arg[] $args
*/
function query_select(Table $table, array $args, array $values) {
	$sql = 'SELECT ';
}

/**  
 * @param Arg[] $args
*/
function query_insert(Table $table, array $args, array $values) {

}

/**  
 * @param Arg[] $args
*/
function query_update(Table $table, array $args, array $values) {

}

/**  
 * @param Arg[] $args
*/
function query_delete(Table $table, array $args, array $values) {

}

enum Table: string{
	case Admin = 'Admin';
	case Utenti = 'Utenti';
	case Citta = 'Citta';
	case Studenti = 'Studenti';
	case Abilita = 'Abilita';
	case Aziende = 'Aziende';
	case Sedi = 'Sedi';
	case Annunci = 'Annunci';
	case Candidarsi = 'Candidarsi';
}

enum Arg: string{
	case IdAdmin = 'IdAdmin';
	case Username = 'Username';
	case HashPassword = 'HashPassword';
	case IdUtente = 'IdUtente';
	case Mail = 'Mail';
	case Telefono = 'Telefono';
	case TwoFA = '2FA';
	case Verificato = 'Verificato';
	case DataCreazione = 'DataCreazione';
	case VisualizzaMail = 'VisualizzaMail';
	case VisualizzaTelefono = 'VisualizzaTelefono';
	case IdCitta = 'IdCitta';
	case Cap = 'Cap';
	case Nome = 'Nome';
	case Provincia = 'Provincia';
	case Paese = 'Paese';
	case CodiceFiscale = 'CodiceFiscale';
	case Cognome = 'Cognome';
	case Sesso = 'Sesso';
	case DataNascita = 'DataNascita';
	case Nazionalita = 'Nazionalita';
	case IndirizzoScolastico = 'IndirizzoScolastico';
	case Voto = 'Voto';
	case Descrizione = 'Descrizione';
	case ResidenzaCitta = 'ResidenzaCitta';
	case ResidenzaVia = 'ResidenzaVia';
	case ResidenzaCivico = 'ResidenzaCivico';
	case DomicilioCitta = 'DomicilioCitta';
	case DomicilioVia = 'DomicilioVia';
	case DomicilioCivico = 'DomicilioCivico';
	case IdAbilita = 'IdAbilita';
	case Studente = 'Studente';
	case IVA = 'IVA';
	case Settore = 'Settore';
	case NumeroDipendenti = 'NumeroDipendenti';
	case Link = 'Link';
	case ReferenteCodiceFiscale = 'ReferenteCodiceFiscale';
	case ReferenteNome = 'ReferenteNome';
	case ReferenteCognome = 'ReferenteCognome';
	case ReferenteDataNascita = 'ReferenteDataNascita';
	case IdSede = 'IdSede';
	case Azienda = 'Azienda';
	case Citta = 'Citta';
	case Via = 'Via';
	case Civico = 'Civico';
	case Legale = 'Legale';
	case IdAnnuncio = 'IdAnnuncio';
	case TipoContratto = 'TipoContratto';
	case Mansione = 'Mansione';
	case AreaDisciplinare = 'AreaDisciplinare';
	case AbilitaRichieste = 'AbilitaRichieste';
	case DataPubblicazione = 'DataPubblicazione';
	case DataScadenza = 'DataScadenza';
	case MaxIscrizioni = 'MaxIscrizioni';
	case Sede = 'Sede';

	public function getType(): string {
		switch ($this) {
			case IdAdmin: return 'i';
			case Username: return 's';
			case HashPassword: return 's';
			case IdUtente: return 'i';
			case Mail: return 's';
			case Telefono: return 's';
			case TwoFA: return 's';
			case Verificato: return 's';
			case DataCreazione: return 's';
			case VisualizzaMail: return 's';
			case VisualizzaTelefono: return 's';
			case IdCitta: return 'i';
			case Cap: return 'i';
			case Nome: return 's';
			case Provincia: return 's';
			case Paese: return 's';
			case CodiceFiscale: return 's';
			case Cognome: return 's';
			case Sesso: return 's';
			case DataNascita: return 's';
			case Nazionalita: return 's';
			case IndirizzoScolastico: return 's';
			case Voto: return 'i';
			case Descrizione: return 's';
			case ResidenzaCitta: return 'i';
			case ResidenzaVia: return 's';
			case ResidenzaCivico: return 'i';
			case DomicilioCitta: return 'i';
			case DomicilioVia: return 's';
			case DomicilioCivico: return 'i';
			case IdAbilita: return 'i';
			case Studente: return 'i';
			case IVA: return 'i';
			case Settore: return 's';
			case NumeroDipendenti: return 'i';
			case Link: return 's';
			case ReferenteCodiceFiscale: return 's';
			case ReferenteNome: return 's';
			case ReferenteCognome: return 's';
			case ReferenteDataNascita: return 's';
			case IdSede: return 'i';
			case Azienda: return 'i';
			case Citta: return 'i';
			case Via: return 's';
			case Civico: return 'i';
			case Legale: return 's';
			case IdAnnuncio: return 'i';
			case TipoContratto: return 's';
			case Mansione: return 's';
			case AreaDisciplinare: return 's';
			case AbilitaRichieste: return 's';
			case DataPubblicazione: return 's';
			case DataScadenza: return 's';
			case MaxIscrizioni: return 'i';
			case Sede: return 'i';
			default: return 's';
		}
	}
}
?>
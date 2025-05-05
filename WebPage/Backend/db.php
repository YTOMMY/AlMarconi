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
 * @param Arg[] $cond_args
*/
function query_select(Table $table, array $select_args, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	foreach($cond_args as $arg) {
		$cond[] = $arg->value . ' = ?';
		$param_type .= $arg->getType();
	}

	$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . $table->value. ' ' . implode(' AND ', $cond) . ';';

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$cond_values);
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $args
*/
function query_insert(Table $table, array $insert_args, array $insert_values) {
	global $conn;
	
	$param_type = '';
	foreach($insert_args as $arg) {
		$insert_placeholder[] = '?';
		$param_type .= $arg->getType();
	}

	$sql = 'INSERT INTO '. $table . '(' . implode(', ', $insert_args) . ') VALUES(' . implode(', ', $insert_placeholder) . ');'; 

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$values);
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $args
 * @param Arg[] $cond_args
*/
function query_update(Table $table, array $update_args, array $update_values, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	$param_values = array_merge($update_values, $cond_values);
	foreach($update_args as $arg) {
		$param_type .= $arg->getType();
	}
	foreach($cond_args as $arg) {
		$cond[] = $arg->value . ' = ?';
		$param_type .= $arg->getType();
	}

	$sql = 'UPDATE '. $table . 'SET ' . implode(' = ?, ', $update_args) . ' WHERE '. implode(' AND ', $cond) . ';';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$param_values);
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $args
*/
function query_delete(Table $table, array $select_args, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	foreach($cond_args as $arg) {
		$cond[] = $arg->value . ' = ?';
		$param_type .= $arg->getType();
	}

	$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . $table->value. ' ' . implode(' AND ', $cond) . ';';

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$cond_values);
	$stmt->execute();
	return $stmt->get_result();
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
			case Arg::IdAdmin: return 'i';
			case Arg::Username: return 's';
			case Arg::HashPassword: return 's';
			case Arg::IdUtente: return 'i';
			case Arg::Mail: return 's';
			case Arg::Telefono: return 's';
			case Arg::TwoFA: return 's';
			case Arg::Verificato: return 's';
			case Arg::DataCreazione: return 's';
			case Arg::VisualizzaMail: return 's';
			case Arg::VisualizzaTelefono: return 's';
			case Arg::IdCitta: return 'i';
			case Arg::Cap: return 'i';
			case Arg::Nome: return 's';
			case Arg::Provincia: return 's';
			case Arg::Paese: return 's';
			case Arg::CodiceFiscale: return 's';
			case Arg::Cognome: return 's';
			case Arg::Sesso: return 's';
			case Arg::DataNascita: return 's';
			case Arg::Nazionalita: return 's';
			case Arg::IndirizzoScolastico: return 's';
			case Arg::Voto: return 'i';
			case Arg::Descrizione: return 's';
			case Arg::ResidenzaCitta: return 'i';
			case Arg::ResidenzaVia: return 's';
			case Arg::ResidenzaCivico: return 'i';
			case Arg::DomicilioCitta: return 'i';
			case Arg::DomicilioVia: return 's';
			case Arg::DomicilioCivico: return 'i';
			case Arg::IdAbilita: return 'i';
			case Arg::Studente: return 'i';
			case Arg::IVA: return 'i';
			case Arg::Settore: return 's';
			case Arg::NumeroDipendenti: return 'i';
			case Arg::Link: return 's';
			case Arg::ReferenteCodiceFiscale: return 's';
			case Arg::ReferenteNome: return 's';
			case Arg::ReferenteCognome: return 's';
			case Arg::ReferenteDataNascita: return 's';
			case Arg::IdSede: return 'i';
			case Arg::Azienda: return 'i';
			case Arg::Citta: return 'i';
			case Arg::Via: return 's';
			case Arg::Civico: return 'i';
			case Arg::Legale: return 's';
			case Arg::IdAnnuncio: return 'i';
			case Arg::TipoContratto: return 's';
			case Arg::Mansione: return 's';
			case Arg::AreaDisciplinare: return 's';
			case Arg::AbilitaRichieste: return 's';
			case Arg::DataPubblicazione: return 's';
			case Arg::DataScadenza: return 's';
			case Arg::MaxIscrizioni: return 'i';
			case Arg::Sede: return 'i';
			default: return 's';
		}
	}
}
?>
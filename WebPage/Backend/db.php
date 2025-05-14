<?php	//Per connettersi al database
require_once 'Arg.php';
require_once 'Table.php';

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
 * @param array<Table> $tables
 * @param array<Arg>|null $select_args
 * @param array<Arg>|null $cond_args
 * @param array<Arg, Arg>|null $join_args
*/
function query_select(array $tables, array|null $select_args = null, array|null $cond_args = null, array|null $cond_values = null, array|null $join_args = null) {
	global $conn;
	
	foreach($tables as &$table) {
		$table = $table->value;
	}
	unset($table);
	
	if(isset($select_args)) {
		foreach($select_args as &$arg) {
			$arg = $arg->info()['dbName'];
		}
		unset($arg);
	} else {
		$select_args = ['*'];
	}
	
	if(isset($join_args)) {
		foreach($join_args as $arg1 => $arg2) {
			$cond[] = $arg1->info()['dbName'] . ' = ' . $arg2->info()['dbName'];
		}
	}
	
	if(isset($cond_args)) {
		$param_type = '';
		foreach($cond_args as $arg) {
			$cond[] = $arg->info()['dbName'] . ' = ?';
			$param_type .= $arg->info()['type'];
		}

		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . implode(', ', $tables) . ' WHERE ' . implode(' AND ', $cond) . ';';

		$stmt = $conn->prepare($sql);
		$stmt->bind_param($param_type, ...$cond_values);
	} else {
		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . implode(', ', $tables);
		if(isset($cond)) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}
		$sql .= ';';
		$stmt = $conn->prepare($sql);
	}
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $insert_args
*/
function query_insert(Table $table, array $insert_args, array $insert_values) {
	global $conn;
	
	$param_type = '';
	foreach($insert_args as $arg) {
		$insert_placeholder[] = '?';
		$param_type .= $arg->info()['type'];
	}

	$sql = 'INSERT INTO '. $table->value . '(' . implode(', ', $insert_args) . ') VALUES(' . implode(', ', $insert_placeholder) . ');'; 

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$insert_values);
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $update_args
 * @param Arg[]|null $cond_args
*/
function query_update(Table $table, array $update_args, array $update_values, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	$param_values = array_merge($update_values, $cond_values);
	foreach($update_args as &$arg) {
		$param_type .= $arg->info()['type'];
		$arg = $arg->info()['dbName'] . ' = ?';
	}
	unset($arg);
	foreach($cond_args as $arg) {
		$cond[] = $arg->info()['dbName'] . ' = ?';
		$param_type .= $arg->info()['type'];
	}

	$sql = 'UPDATE '. $table->value . ' SET ' . implode(', ', $update_args) . ' WHERE '. implode(' AND ', $cond) . ';';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$param_values);
	
	return $stmt->execute();
}

/**  
 * @param Arg[] $cond_args
*/
function query_delete(Table $table, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	foreach($cond_args as $arg) {
		$cond[] = $arg->info()['dbName'] . ' = ?';
		$param_type .= $arg->info()['type'];
	}

	$sql = 'DELETE  FROM ' . $table->value. ' WHERE ' . implode(' AND ', $cond) . ';';

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$cond_values);
	$stmt->execute();
	return $stmt->get_result();
}

/*
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
	case Password = 'HashPassword';
	case IdUtente = 'IdUtente';
	case Email = 'Mail';
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
	case LinkEsterno = 'Link';
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
			case Arg::Password: return 's';
			case Arg::IdUtente: return 'i';
			case Arg::Email: return 's';
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
			case Arg::LinkEsterno: return 's';
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
	
	/**
	 * @param Table $table
	*//*
	public static function fromJson($table, $value) {
		switch ($table) {
			case Table::Admin: switch($value) {
				
				default: return null;
			}
			case Table::Utenti: switch($value) {
				case 'id': return Arg::IdUtente;
				case 'email': return Arg::Email;
				case 'password': return Arg::Password;
				case 'telefono': return Arg::Telefono;
				case '2FA': return Arg::TwoFA;
				case 'visualizzaEmail': return Arg::VisualizzaMail;
				case 'visualizzaTelefono': return Arg::VisualizzaTelefono;
				default: return null;
			}
			case Table::Citta: switch($value) {
				
				default: return null;
			}
			case Table::Studenti: switch($value) {
				case 'id': return Arg::IdUtente;
				case 'cf': return Arg::CodiceFiscale;
				case 'nome': return Arg::Nome;
				case 'cognome': return Arg::Cognome;
				case 'sesso': return Arg::Sesso;
				case 'nascita': return Arg::DataNascita;
				case 'nazionalita': return Arg::Nazionalita;
				case 'indirizzo': return Arg::IndirizzoScolastico;
				case 'voto': return Arg::Voto;
				case 'descrizione': return Arg::Descrizione;
				case 'residenza': return [Arg::ResidenzaCitta, Arg::ResidenzaVia, Arg::ResidenzaCivico];
				case 'domicilio': return [Arg::DomicilioCitta, Arg::DomicilioVia, Arg::DomicilioCivico];
				/*case '': return Arg::IdAbilita;
				case '': return Arg::Studente;*//*
				default: return null;
			}
			case Table::Aziende: switch($value) {
				case 'id': return Arg::IdAnnuncio;
				case 'iva': return Arg::IVA;
				case 'nomeAzienda': return Arg::Nome;
				case 'settore': return Arg::Settore;
				case 'dipendenti': return Arg::NumeroDipendenti;
				case 'link': return Arg::LinkEsterno;
				case 'cf': return Arg::ReferenteCodiceFiscale;
				case 'nome': return Arg::ReferenteNome;
				case 'cognome': return Arg::ReferenteCognome;
				case 'nascita': return Arg::ReferenteDataNascita;
				default: return null;
			}
			case Table::Annunci: switch($value) {
				case 'id': return Arg::IdAnnuncio;
				case 'tipo': return Arg::TipoContratto;
				case 'mansione': return Arg::Mansione;
				case 'descrizione': return Arg::Descrizione;
				case 'areaDisciplinare': return Arg::AreaDisciplinare;
				case 'abilita': return Arg::AbilitaRichieste;
				case 'pubblicazione': return Arg::DataPubblicazione;
				case 'scadenza': return Arg::DataScadenza;
				case 'maxIscrizioni': return Arg::MaxIscrizioni;
				case 'azienda': return Arg::Azienda;
				case 'sede': return Arg::Sede;
				default: return null;
			}
			default: return null;
		}
	}
	
	/**
	 * @param Table $table
	*//*
	public function jsonValue($table): string {
		switch($table) {
			case Table::Admin: switch($this) {
				
				default: return '';
			}
			case Table::Utenti: switch($this) {
				case Arg::IdUtente: return 'id';
				case Arg::Email: return 'email';
				case Arg::Password: return 'password';
				case Arg::Telefono: return 'telefono';
				case Arg::TwoFA: return '2FA';
				case Arg::VisualizzaMail: return 'visualizzaEmail';
				case Arg::VisualizzaTelefono: return 'visualizzaTelefono';
				default: return '';
			}
			case Table::Citta: switch($this) {
				
				default: return '';
			}
			case Table::Studenti: switch($this) {
				case Arg::IdUtente: return 'id';
				case Arg::CodiceFiscale: return 'cf';
				case Arg::Nome: return 'nome';
				case Arg::Cognome: return 'cognome';
				case Arg::Sesso: return 'sesso';
				case Arg::DataNascita: return 'nascita';
				case Arg::Nazionalita: return 'nazionalita';
				case Arg::IndirizzoScolastico: return 'indirizzo';
				case Arg::Voto: return 'voto';
				case Arg::Descrizione: return 'descrizione';
				case Arg::ResidenzaCitta: return '';
				case Arg::ResidenzaVia: return '';
				case Arg::ResidenzaCivico: return '';
				case Arg::DomicilioCitta: return '';
				case Arg::DomicilioVia: return '';
				case Arg::DomicilioCivico: return '';
				case Arg::IdAbilita: return '';
				case Arg::Studente: return '';
				default: return '';
			}
			case Table::Aziende: switch($this) {
				
				default: return '';
			}
			case Table::Annunci: switch($this) {
				case Arg::IdAnnuncio: return "id";
				case Arg::TipoContratto: return "tipo";
				case Arg::Mansione: return "mansione";
				case Arg::Descrizione: return "descrizione";
				case Arg::AreaDisciplinare: return "areaDisciplinare";
				case Arg::AbilitaRichieste: return "abilita";
				case Arg::DataPubblicazione: return "pubblicazione";
				case Arg::DataScadenza: return "scadenza";
				case Arg::MaxIscrizioni: return "maxIscrizioni";
				case Arg::Azienda: return "azienda";
				case Arg::Sede: return "sede";
				default: return '';
			}
			default: return '';
		}
		/*
		switch ($this) {
			case Arg::IdAdmin: return 'idAdmin';
			case Arg::Username: return 'username';
			case Arg::Password: return 'password';
			case Arg::IdUtente: return 'idUtente';
			case Arg::Email: return 'email';
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
			case Arg::LinkEsterno: return 's';
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
			case Arg::AbilitaRichieste: return '';
			case Arg::DataPubblicazione: return 'pubblicazione';
			case Arg::DataScadenza: return 'scadenza';
			case Arg::MaxIscrizioni: return 'maxIscrizioni';
			case Arg::Sede: return 'sede';
			default: return 's';
		}
		
	}
}*/
?>
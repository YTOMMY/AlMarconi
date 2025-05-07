<?php	//Per gestire le funzioni relative agli utenti in generale
require_once 'db.php';

// Controlla se un'email esiste
function check_email($email) {
	
	// Controllo del formato
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		// Controllo dell'esistenza del dominio
		$domain = substr(strrchr($email, "@"), 1);
		if (checkdnsrr($domain, "MX")) {
			return 'valid';
		} else {
			return 'invalid';
		}
		
	// Potrebbe essere un admin
	} else {
		$domain = substr(strrchr($email, "@"), 1);
		if(ctype_digit($domain)) {
			return 'admin';
		} else {
			return 'invalid';
		}
	}
}

// Creazione di un account
function create_account($data) {
	global $conn;
	
	if($data['tipo'] != 'admin') {
		
		// Se non è admin
		if(check_email($data['email']) != 'valid') {
			return false;
		}
		
		// Creazione in tabella 'Utenti'
		$sql = 'INSERT INTO Utenti(Mail, ' . ($data['telefono'] != null ? 'Telefono, ' : '') . 'HashPassword) ' .
			   'VALUES(?, ?, ' . ($data['telefono'] != null ? '?' : '') . ');';
		$hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
		
		$stmt = $conn->prepare($sql);
		if($data['telefono'] != null) {
			$stmt->bind_param('sss', $data['email'], $data['telefono'], $hashed_password);
		} else {
			$stmt->bind_param('ss', $data['email'], $hashed_password);
		}
		$stmt->execute();
		
		// Query al database per sapere l'id dell'utente
		$sql = 'SELECT IdUtente FROM Utenti WHERE Mail = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $data['email']);
		$stmt->execute();
		$result = $stmt->get_result();
		$record = $result->fetch_assoc();
		$id = $record['IdUtente'];	
		
		try {
			if ($data['tipo'] == 'studente') {
				
				// Creazione in tabella 'Studenti'
				$attr = ['IdUtente', 'CodiceFiscale', 'Nome', 'Cognome', 'DataNascita', 'Nazionalita', 'ResidenzaCitta', 'ResidenzaVia', 'ResidenzaCivico'];
				$values = [$id, $data['cf'], $data['nome'], $data['cognome'], $data['nascita'], $data['nazionalita'], $data['residenza']['citta'], $data['residenza']['via'], $data['residenza']['civico']];
				$values_type = 'isssssisi';
				if(isset($data['sesso'])) {
					array_push($values, $data['sesso']);
					$values_type .= 's';
					array_push($attr, 'Sesso');
				}
				if(isset($data['domicilio']) && isset($data['domicilio']['citta'])) {
					array_push($values, $data['domicilio']['citta'], $data['domicilio']['via'], $data['domicilio']['civico']);
					$values_type .= 'isi';
					array_push($attr, 'DomicilioCitta', 'DomicilioVia', 'DomicilioCivico');
				}
				if(isset($data['indirizzoScolastico'])) {
					array_push($values, $data['indirizzoScolastico']);
					$values_type .= 's';
					array_push($attr, 'IndirizzoScolastico');
				}
				$sql = 'INSERT INTO Studenti(' . implode(", ", $attr) . ') VALUES (' . str_repeat('?, ', count($attr)-1) . '?);';
				
				$stmt = $conn->prepare($sql);
				$stmt->bind_param($values_type, ...$values);
				$stmt->execute();
				
			} else if ($data['tipo'] == 'azienda'){
				//Creazione in tabella 'Aziende'
				$sql = "INSERT INTO Aziende(IdUtente, IVA, Nome, Settore, ReferenteCodiceFiscale, ReferenteNome, ReferenteCognome, ReferenteDataNascita) VALUES($id, ?, ?, ?, ?, ?, ?, ?);";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('issssss', $data['iva'], $data['nomeAzienda'], $data['settore'], $data['cf'], $data['nome'], $data['cognome'], $data['nascita']);
				$stmt->execute();
				
				$sql = "INSERT INTO Sedi(Azienda, Citta, Via, Civico, Legale) VALUES($id, ?, ?, ?, 1)";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('isi', $data['sede']['citta'], $data['sede']['via'], $data['sede']['civico']);
				$stmt->execute();
			}
		} catch(Exception  $e) {
			$sql = "DELETE FROM Utenti WHERE IdUtente = $id";
			$conn->query($sql);
			echo $e;
			return false;
		}
	} else {
		
		// Se è un admin
		if(check_email($data['email']) != 'admin') {
			return false;
		}
		//da fare
	}
	
	$_SESSION['id'] = $id;
	$_SESSION['tipo'] = get_type($id);
	return true;		
}

function OTP() {
	// codice OTP via mail (per registrazione e 2FA)
}

function verify() {
	// verifica un account aziendale da parte della scuola
}

// Login nell'account
function login($email, $password) {
	global $conn;
	
	// Query al database per sapere mail e hash della password
	$tabella = 'Utenti';
	$sql = "SELECT IdUtente, HashPassword FROM $tabella WHERE Mail = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();
	
	// Controllo password
	$hashed_password = $record['HashPassword'];
	if (!password_verify($password, $hashed_password)) {
		return false;
	}
	$_SESSION['id'] = $record['IdUtente'];
	$_SESSION['tipo'] = get_type($record['IdUtente']);
	
	return true;
	// da aggiungere 2FA
}

// Controllo se un utente è stato verificato
function is_verified($id) {
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT Verificato FROM $tabella WHERE IdUtente = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if (!$result) {
		return null;
	}
	$record = $result->fetch_assoc();
	if($record['Verificato'] == 1) {
		return true;
	} else {
		return false;
	}
	return true;
}

// Controllo del tipo dell'utente ('studente', 'azienda', 'admin'
function get_type($id) {
	global $conn;
	$sql = 'SELECT idUtente FROM aziende WHERE idUtente = ?';
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		return 'azienda';
	} else {
		return 'studente';
	}
}

function check_password($id, $password) {
	global $conn;
	$sql = 'SELECT HashPassword FROM Utenti WHERE IdUtente = ?';
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();
	
	// Controllo della password
	$hashed_password = $record['HashPassword'];
	return password_verify($password, $hashed_password);
}

function update_account($id = null, $data) {
	if($id != null) {
		if(isset($data['password'])) {
			if(!check_password($id, $password)) {
				return false;
			}
		}
	} else if(isset($_SESSION['id'])) {
		$id = $_SESSION['id'];
	}

	$attr_list = [];
	$var_list = [];
	$more_attr = false;
	foreach($data as $attr) {
		$attr = Arg::fromJson($attr) ?? $attr;
		// 			DA FINIRE
	}
	
	foreach($data as $attr => $val) {
		switch($attr) {
			case 'email':
			  array_push($attr_list, Arg::Email);
				array_push($val_list, $val);
				break;
			case 'password':
			  array_push($attr_list, Arg::Password);
				array_push($val_list, $val);
				break;
			case 'telefono':
				array_push($attr_list, Arg::Telefono);
				array_push($val_list, $val);
				break;
			case '2FA':
				array_push($attr_list, Arg::TwoFA);
				array_push($val_list, $val);
				break;
			case 'visualizzaEmail':
				array_push($attr_list, Arg::VisualizzaMail);
				array_push($val_list, $val);
				break;
			case 'visualizzaTelefono':
				array_push($attr_list, Arg::VisualizzaTelefono);
				array_push($val_list, $val);
				break;
			default:
				$more_attr = true;
				break;
		}
	}
	
	global $conn;
	$conn->begin_transaction();
	try {
	  query_update(Table::Utenti, $attr_list, $var_list, [Arg::IdUtente], [$id]);
	  
	  $conn->commit();
	} catch (mysqli_sql_exception $e) {
	  $conn->rolback();
	}
}

// Cambio password di un utente
/*
function change_password($old_password, $new_password) {
	
	// Verifica che l'utente sia loggato
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	// Query per ottenere la vecchia password
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT HashPassword FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	// Controllo password
	$hashed_password = $record['HashPassword'];
	if (!password_verify($old_password, $hashed_password)) {
		return false;
	}
	
	// Update password
	$sql = "UPDATE $tabella SET HashPassword = ? WHERE IdUtente = {$_SESSION['id']}";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
}
*/

// Logout dall'account
function logout(){
	
	// Verifica che l'utente sia loggato
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	unset($_SESSION['id']);
	unset($_SESSION['tipo']);
	return true;
}

function delete_account($id, $password) {
	
	// Query per ottenere la password
	if(!check_password($id, $password)) {
		return false;
	}
	
	global $conn;
	
	// Eliminazione dell'account
	$sql = 'DELETE FROM Utenti WHERE IdUtente = ?';
	$stmt->bind_param('i', $id);
	if ($stmt->execute()) {
		return true;
		session_destroy();
	}
	return false;
}
?>
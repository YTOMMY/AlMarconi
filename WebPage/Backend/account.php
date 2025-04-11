<?php	//Per gestire le funzioni relative agli utenti in generale
require_once 'db.php';

function check_email($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$domain = substr(strrchr($email, "@"), 1);
		if (checkdnsrr($domain, "MX")) {
			return 'valid';
		} else {
			return 'invalid';
		}
	} else {
		$domain = substr(strrchr($email, "@"), 1);
		if(ctype_digit($domain)) {
			return 'admin';
		} else {
			return 'invalid';
		}
	}
}

function create_account($data) {
	global $conn;
	
	if($data['tipo'] != 'admin') {
		if(check_email($data['email']) != 'valid') {
			return false;
		}
		
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
		
		$sql = 'SELECT IdUtente FROM Utenti WHERE Mail = ?';
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $data['email']);
		$stmt->execute();
		$result = $stmt->get_result();
		$record = $result->fetch_assoc();
		$id = $record['IdUtente'];	
		
		if ($data['tipo'] == 'studente') {
			$attr = ['IdUtente', 'CodiceFiscale', 'Nome', 'Cognome', 'DataNascita', 'Nazionalita', 'ResidenzaCitta', 'ResidenzaVia', 'ResidenzaCivico'];
			$values = [$id, $data['cf'], $data['nome'], $data['cognome'], $data['nascita'], $data['nazionalita'], $data['residenza']['citta'], $data['residenza']['via'], $data['residenza']['civico']];
			$values_type = 'isssssisi';
			if(isset($data['sesso'])) {
				array_push($values, $data['sesso']);
				$values_type .= 's';
				array_push($attr, 'Sesso');
			}
			if(isset($data['domicilio'])) {
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
			$sql = "INSERT INTO Aziende(IdUtente, IVA, Nome, Settore, ReferenteCodiceFiscale, ReferenteNome, ReferenteCognome, ReferenteDataNascita) VALUES($id, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('issssss', $data['iva'], $data['nomeAzienda'], $data['settore'], $data['cf'], $data['nome'], $data['cognome'], $data['nascita']);
			$stmt->execute();
			
			$sql = "INSERT INTO Sedi(Azienda, Citta, Via, Civico, Legale) VALUES($id, ?, ?, ?, 1)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('isi', $data['sede']['citta'], $data['sede']['via'], $data['sede']['civico']);
			$stmt->execute();
		}
		
	} else {
		if(check_email($data['email']) != 'admin') {
			return false;
		}
		//da fare
	}
	return true;		
}

function OTP() {
	// codice OTP via mail (per registrazione e 2FA)
}

function verify() {
	// verifica un account aziendale da parte della scuola
}

function login($email, $password) {
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT IdUtente, HashPassword FROM $tabella WHERE Mail = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();

	$hashed_password = $record['HashPassword'];
	if (!password_verify($password, $hashed_password)) {
		return false;
	}
	$_SESSION['id'] = $record['IdUtente'];
	
	return true;
	// da aggiungere 2FA
}

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

function change_password($old_password, $new_password) {
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT HashPassword FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	$hashed_password = $record['HashPassword'];
	if (!password_verify($old_password, $hashed_password)) {
		return false;
	}
	
	$sql = "UPDATE $tabella SET HashPassword = ? WHERE IdUtente = {$_SESSION['id']}";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
}

function logout(){
	if(!isset($_SESSION['id'])) {
		return false;
	}
	session_destroy();
	return true;
}

function delete_account($password) {
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT HashPassword FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	$hashed_password = $record['HashPassword'];
	if (!password_verify($password, $hashed_password)) {
		return false;
	}
	
	$sql = "DELETE FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	if ($conn->query($sql) === true) {
		return true;
		session_destroy();
	}
	return false;
}
?>
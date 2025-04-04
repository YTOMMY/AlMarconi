<?php	//Per gestire le funzioni relative agli utenti in generale
require_once 'db.php';

function check_email($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$domain = substr(strrchr($email, "@"), 1);
		if (checkdnsrr($domain, "MX")) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

// curl -i -h "Content-type: application/json" http://localhost/AlMarconi/WebService/api.php/register -d "{\"tipo\": \"studente\", \"mail\": \"prova@gmail.com\", \"password\": \"12345678\"}"

function create_account($data) {
	global $conn;
	echo 'aaaaa';
	if($data['tipo'] != 'admin') {
		$table = 'Utenti';
		$sql = 'INSERT INTO Utenti(Mail, ' . ($data['telefono'] != null ? 'Telefono, ' : '') . 'HashPassword) ' .
			   'VALUES(?, ?, ' . ($data['telefono'] != null ? '?' : '') . ');';
		$hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
		echo $sql;
		
		$stmt = $conn->prepare($sql);
		if($data['telefono'] != null) {
			$stmt->bind_param('sss', $data['mail'], $data['telefono'], $hashed_password);
		} else {
			$stmt->bind_param('ss', $data['mail'], $hashed_password);
		}
		$stmt->execute();
	} else {
	
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
	session_start();
	
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT IdUtente, HashPassword FROM $tabella WHERE Mail = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();

	$hashed_password = $record['HashPassword'];
	if (password_verify($password, $hashed_password)) {
		$_SESSION['id'] = $record['IdUtente'];
		echo 'login';
		return true;
	} else {
		return false;
	}
	
	// da aggiungere 2FA
}

function is_verified($id) {
	global $conn;
	$tabella = 'Utenti';
	$sql = "SELECT Verificato FROM $tabella WHERE IdUtente = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->execute();
	
	if (!($record = $result->fetch_assoc())) {
		return null;
	}
	if($record['Verifiacto'] == 1) {
		return true;
	} else {
		return false;
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
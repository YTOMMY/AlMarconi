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

function create_account($tipo, $email, $password) {
	// registrare un account
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
	$tabella = 'utenti';
	$sql = "SELECT IdUtente, HashPassword FROM $tabella WHERE Mail = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();

	$hashed_password = $record['HashPassword'];
	if (password_verify($password, $hashed_password)) {
		$_SESSION['id'] = $record['IdUtente'];
		return true;
	} else {
		return false;
	}
	
	// da aggiungere 2FA
}

function is_verified($id) {
	global $conn;
	$tabella = 'utenti';
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
	$tabella = 'utenti';
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
	$tabella = 'utenti';
	$sql = "SELECT Password FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	$hashed_password = $record['Password'];
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
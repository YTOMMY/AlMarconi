<!-- Per gestire le funzioni relative agli utenti in generale --!>

<?php
require_once 'db.php';

function login(&mail, &password) {
	session_start();
	
	$tabella = 'utenti';
	$sql = "SELECT IdUtente, Password FROM $tabella WHERE mail = ?"
	
	$stmt = global $conn->prepare($sql);
	$stmt->bind_param('s', $mail);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();

	$hashed_password = $record['Password'];
	if (password_verify($password, $hashed_password)) {
		$_SESSION['id'] = $record['IdUtente'];
		return true;
	else {
		return false;
	}
	
	// da mettere 2FA
}

function change_password($old_password, $new_password) {
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	$tabella = 'utenti';
	$sql = "SELECT Password FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = global $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	$hashed_password = $record['Password'];
	if (!password_verify($old_password, $hashed_password)) {
		return false;
	}
	
	$sql = "UPDATE $tabella SET Password = ? WHERE IdUtente = {$_SESSION['id']}";
	$stmt = global $conn->prepare($sql);
	$stmt->bind_param('s', $mail);
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
	
	$tabella = 'utenti';
	$sql = "SELECT Password FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	
	$result = global $conn->query($sql);
	$result = $query->get_result();
	$record = $result->fetch_assoc();
	
	$hashed_password = $record['Password'];
	if (!password_verify($password, $hashed_password)) {
		return false;
	}
	
	$sql = "DELETE FROM $tabella WHERE IdUtente = {$_SESSION['id']}";
	if (global $conn->query($sql) === true) {
		return true;
		session_destroy();
	}
	return false;
}
?>
<!-- Per gestire le funzioni relative agli utenti in generale --!>

<?php
include 'db.php';

function login(&mail, &password) {
	session_start();
	
	$tabella = 'utenti';
	$campo = 'password';
	$sql = "SELECT $campo FROM $utenti WHERE mail = ?"
	
	$query = $conn->query($sql);
	$query->bind_param('s', $mail);
	$query->execute();
	$result = $query->get_result();
	$record = $result->fetch_assoc();

	$hashed_password = $record[$campo];
		if (password_verify($password, $hashed_password)) {
		$_SESSION['username'] = $mail;
		return true;
	else {
		return false;
	}
}
?>
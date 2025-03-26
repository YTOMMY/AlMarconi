<?php
$host = 'LocalHost';
$dbname = 'AlMarconi';
$username = '';
$password = '';

$conn = new mysqli($host, $dbname, $username, $password);
if($conn->connect_errno) {
	die('Connessione non riuscita: ' . $conn->connect_error);
}

$conn->set_charset('utf8');
?>
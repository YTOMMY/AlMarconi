<?php	//Per connettersi al database
$host = 'localhost';
$dbname = 'AlMarconi';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_errno) {
	die('Connessione non riuscita: ' . $conn->connect_error);
}

$conn->set_charset('utf8');
?>
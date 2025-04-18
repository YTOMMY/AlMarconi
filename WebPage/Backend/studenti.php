<?php	// Per gestire le funzioni relative alle aziende
require_once 'db.php';

function getStudente($id = null) {
	global $conn;
	if(!isset($id)) {
		if(isset($_SESSION['id']) && $_SESSION['tipo'] == 'studente') {
			$sql = 'SELECT Nome, Cognome, Sesso, Nazionalita, IndirizzoScolastico, Voto, Descrizione FROM Studenti WHERE idUtente = ' . $_SESSION['id'] . ';';
			$result = $conn->query($sql);
			return $result->fetch_assoc();
		}
	} else {
		$sql = 'SELECT Nome, Cognome, Sesso, Nazionalita, IndirizzoScolastico, Voto, Descrizione FROM Studenti WHERE idUtente = ?;';
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows != 0) {
			return $result->fetch_assoc();
		} else {
			return null;
		}
	}
}
?>
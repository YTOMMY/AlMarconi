<?php	//Per gestire le funzioni relative alle aziende
require_once 'db.php';

function getAzienda($id = null) {
	global $conn;
	if(!isset($id)) {
		if(isset($_SESSION['id']) && $_SESSION['tipo'] == 'azienda') {
			$sql = 'SELECT Nome, Settore, NumeroDipendenti, Link, Descrizione FROM Aziende WHERE idUtente = ' . $_SESSION['id'] . ';';
			$result = $conn->query($sql);
			return $result->fetch_assoc();
		}
	} else {
		$sql = 'SELECT Nome, Settore, NumeroDipendenti, Link, Descrizione FROM Aziende WHERE idUtente = ?;';
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
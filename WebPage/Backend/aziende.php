<?php	//Per gestire le funzioni relative alle aziende
require_once 'db.php';


function get_azienda($id = null) {
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


function exists_annuncio($id) {
	$result = query_select(Table::Annunci, null, [Arg::IdAnnuncio], [$id]);
	if ($result) {
		return true;
	} else {
		return false;
	}
}

function get_annuncio($id = null, $data = null) {
	if(isset($data)) {
		foreach($data as &$attr) {
			$attr = Arg::fromJson(Table::Annunci, $attr);
		}
		unset($attr);
	}
	
	if(isset($id)) {
		if(!exists_annuncio($id)) {
			return false;
		}
		$result = query_select(Table::Annunci, $data, [Arg::IdAnnuncio], [$id]);
		return $result->fetch_assoc();
	} else {
		$result = query_select(Table::Annunci, $data, null, null);
		while($row = $result->fetch_assoc()) {
			$output[] = $row;
		}
		return $output;
	}
}
?>
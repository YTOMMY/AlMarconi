<?php	// Per gestire le funzioni relative alle aziende
require_once 'db.php';
require_once 'Table.php';
require_once 'Arg.php';
require_once 'aziende.php';
require_once '../api.php';

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

function update_studente($id, $data) {
	$attr_list = [];
	$var_list = [];
	foreach($data as $attr => $value) {
		$arg = Arg::fromJson([Table::Studenti], $attr);
		if($arg != null) {
			if(!is_array($arg)) {
				$attr_list[] = $arg;
				$var_list[] = $value;
			} else {
				foreach($arg as $a) {
					$attr_list[] = $a;
				}
				foreach($value as $v) {
					$var_list[] = $v;
				}
			}
		}
	}
	
	return query_update(Table::Studenti, $attr_list, $var_list, [Arg::IdUtente], [$id]);
}
?>
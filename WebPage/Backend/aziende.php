<?php	//Per gestire le funzioni relative alle aziende
require_once 'db.php';
require_once 'Table.php';
require_once 'Arg.php';

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
	$result = query_select([Table::Annunci], null, [Arg::IdAnnuncio], [$id]);
	if ($result) {
		return true;
	} else {
		return false;
	}
}

function get_annuncio($id = null, $data = null) {
	if(isset($data)) {
		foreach($data as &$attr) {
			$attr = Arg::fromJson([Table::Annunci], $attr);
		}
		unset($attr);
	}
	
	if(isset($id)) {
		if(!exists_annuncio($id)) {
			return false;
		}
		$result = query_select([Table::Annunci], $data, [Arg::IdAnnuncio], [$id]);
		return $result->fetch_assoc();
	} else {
		$result = query_select([Table::Annunci], $data, null, null);
		while($row = $result->fetch_assoc()) {
			$output[] = $row;
		}
		return $output;
	}
}

function update_azienda($id, $data) {
	$attr_list = [];
	$var_list = [];
	foreach($data as $attr => $value) {
		$arg = Arg::fromJson([Table::Aziende], $attr);
		if($arg != null) {
			if(!is_array($arg)) {
				$attr_list[] = $arg;
				$var_list[] = $value;
			}
		}
	}
	
	return query_update(Table::Aziende, $attr_list, $var_list, [Arg::IdUtente], [$id]);
}

/*
<?php
// ...existing code...

function delete_annuncio($id) {
    return query_delete(Table::Annunci, [Arg::IdAnnuncio], [$id]);
}

function update_annuncio($id, $data) {
    $attr_list = [];
    $var_list = [];
    foreach($data as $attr => $value) {
        $arg = Arg::fromJson([Table::Annunci], $attr);
        if($arg != null) {
            $attr_list[] = $arg;
            $var_list[] = $value;
        }
    }
    return query_update(Table::Annunci, $attr_list, $var_list, [Arg::IdAnnuncio], [$id]);
}

function create_annuncio($data) {
    $attr_list = [];
    $var_list = [];
    foreach($data as $attr => $value) {
        $arg = Arg::fromJson([Table::Annunci], $attr);
        if($arg != null) {
            $attr_list[] = $arg;
            $var_list[] = $value;
        }
    }
    return query_insert(Table::Annunci, $attr_list, $var_list);
}
// ...existing code...
*/
?>
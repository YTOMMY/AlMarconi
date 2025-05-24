<?php	//Per gestire le funzioni relative alle aziende

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
	} else {
		$data = [Arg::AnnuncioAll, Arg::NomeAzienda, Arg::SedeCitta, Arg::SedeVia, Arg::SedeCivico, Arg::Settore];
	}
	
	if(isset($id)) {
		if(!exists_annuncio($id)) {
			return false;
		}
		$result = query_select([Table::Annunci, Table::Aziende], $data, [Arg::IdAnnuncio], [$id], [Arg::AziendaAnnuncio], [Arg::IdAzienda]);
		return Arg::toJsonArray([Table::Annunci, Table::Aziende], $result->fetch_assoc());
	} else {
		$result = query_select([Table::Annunci, Table::Aziende], $data, null, null, [Arg::AziendaAnnuncio], [Arg::IdAzienda]);
		while($row = $result->fetch_assoc()) {
			$output[] = Arg::toJsonArray([Table::Annunci, Table::Aziende], $row);
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

function get_annuncio_owner($id_annuncio) {
	$result = query_select([Table::Annunci], [Arg::AziendaAnnuncio], [Arg::IdAnnuncio], [$id_annuncio]);
	return $result->fetch_assoc()[Arg::IdAnnuncio->info()['dbName']];
}

function is_owner($id_utente, $id_annuncio) {
	if ($id_utente != get_annuncio_owner($id_annuncio)) {
		unauthorized_error();
	}
	return true;
}

function delete_annuncio($id, $password = null) {
		
	$id_utente = get_annuncio_owner($id);
	$id_utente = check_credentials($id_utente, $password);

	if($id_utente == null) {
		return false;
	}
	if(get_type($id_utente) != 'azienda') {
		return false;
	}
	return query_delete(Table::Annunci, [Arg::IdAnnuncio], [$id]);
}

function update_annuncio($id, $password, $data) {
    
	$id_utente = get_annuncio_owner($id);
	$id_utente = check_credentials($id_utente, $password);
	
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
	if(!isset($_SESSION['id']) || get_type($_SESSION['id']) != 'azienda') {
		unauthorized_error();
	}
	$id = $_SESSION['id'];
	if(get_type($id) != 'azienda') {
		unauthorized_error();
	}

    $attr_list = [];
    $var_list = [];
    foreach($data as $attr => $value) {
        $arg = Arg::fromJson([Table::Annunci], $attr);
        if($arg != null) {
            $attr_list[] = $arg;
            $var_list[] = $value;
        }
    }
	$attr_list[] = Arg::AziendaAnnuncio;
	$var_list[] = $id;
    return query_insert(Table::Annunci, $attr_list + [Arg::AziendaAnnuncio], $var_list + [$id]);
}

function candidarsi($idAnnuncio) {
	if(!isset($_SESSION['id'])) {
		unauthorized_error();
	}
	$id = $_SESSION['id'];
	if(get_type($id) != 'studente') {
		unauthorized_error();
	}
	if(!exists_annuncio($idAnnuncio)) {
		not_found_error();
	}
	
	return query_insert(Table::Candidarsi, [Arg::AnnuncioCandidatura, Arg::StudenteCandidatura], [$idAnnuncio, $id]);
}

function get_candidati($idAnnuncio) {
	if(!exists_annuncio($idAnnuncio)) {
		not_found_error();
	}

	$result = query_select([Table::Candidarsi, Table::Studenti], [Arg::StudenteCandidatura, Arg::NomeStudente, Arg::Cognome], [Arg::AnnuncioCandidatura], [$idAnnuncio], [Arg::StudenteCandidatura], [Arg::IdStudente]);
	
	while($row = $result->fetch_assoc()) {
		$studenti[] = Arg::toJsonArray([Table::Candidarsi, Table::Studenti], $row);
	}
	if(!isset($studenti)) {
		return false;
	}
	return $studenti;
}
?>
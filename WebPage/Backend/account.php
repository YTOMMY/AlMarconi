<?php	//Per gestire le funzioni relative agli utenti in generale

// Controlla se un'email esiste
function check_email($email) {
	
	// Controllo del formato
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		// Controllo dell'esistenza del dominio
		$domain = substr(strrchr($email, "@"), 1);
		if (checkdnsrr($domain, "MX")) {
			return true;
		}
	return false;
}

// Creazione di un account
function create_account($data) {
	global $conn;
	
	if(!check_email($data['email'])) {
		return false;
	}
	
	// Creazione in tabella 'Utenti'
	$sql = 'INSERT INTO Utenti(Verificato, Mail, ' . ($data['telefono'] != null ? 'Telefono, ' : '') . 'HashPassword) ' .
		   'VALUES(true, ?, ?, ' . ($data['telefono'] != null ? '?' : '') . ');';
	$hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
	
	$stmt = $conn->prepare($sql);
	if($data['telefono'] != null) {
		$stmt->bind_param('sss', $data['email'], $data['telefono'], $hashed_password);
	} else {
		$stmt->bind_param('ss', $data['email'], $hashed_password);
	}
	$stmt->execute();
	
	// Query al database per sapere l'id dell'utente
	$sql = 'SELECT IdUtente FROM Utenti WHERE Mail = ?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $data['email']);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();
	$id = $record['IdUtente'];	
	
	try {
		if ($data['tipo'] == 'studente') {
			
			// Creazione in tabella 'Studenti'
			$attr = ['IdUtente', 'CodiceFiscale', 'Nome', 'Cognome', 'DataNascita', 'Nazionalita', 'ResidenzaCitta', 'ResidenzaVia', 'ResidenzaCivico'];
			$values = [$id, $data['cf'], $data['nome'], $data['cognome'], $data['nascita'], $data['nazionalita'], $data['residenza']['citta'], $data['residenza']['via'], $data['residenza']['civico']];
			$values_type = 'isssssssi';
			if(isset($data['sesso'])) {
				array_push($values, $data['sesso']);
				$values_type .= 's';
				array_push($attr, 'Sesso');
			}
			if(isset($data['domicilio']) && isset($data['domicilio']['citta'])) {
				array_push($values, $data['domicilio']['citta'], $data['domicilio']['via'], $data['domicilio']['civico']);
				$values_type .= 'ssi';
				array_push($attr, 'DomicilioCitta', 'DomicilioVia', 'DomicilioCivico');
			}
			if(isset($data['indirizzoScolastico'])) {
				array_push($values, $data['indirizzoScolastico']);
				$values_type .= 's';
				array_push($attr, 'IndirizzoScolastico');
			}
			$sql = 'INSERT INTO Studenti(' . implode(", ", $attr) . ') VALUES (' . str_repeat('?, ', count($attr)-1) . '?);';
			
			$stmt = $conn->prepare($sql);
			$stmt->bind_param($values_type, ...$values);
			$stmt->execute();
			
		} else if ($data['tipo'] == 'azienda'){
			//Creazione in tabella 'Aziende'
			$sql = "INSERT INTO Aziende(IdUtente, IVA, Nome, Settore, ReferenteCodiceFiscale, ReferenteNome, ReferenteCognome, ReferenteDataNascita, SedeCitta, SedeVia, SedeCivico) VALUES($id, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('issssssssi', $data['iva'], $data['nomeAzienda'], $data['settore'], $data['cf'], $data['nome'], $data['cognome'], $data['nascita'], $data['sede']['citta'], $data['sede']['via'], $data['sede']['civico']);
			$stmt->execute();
		}
	} catch(Exception  $e) {
		$sql = "DELETE FROM Utenti WHERE IdUtente = $id";
		$conn->query($sql);
		return false;
	}
	
	$_SESSION['id'] = $id;
	$_SESSION['tipo'] = get_type($id);
	return true;		
}

// Login nell'account
function login($email, $password) {
	global $conn;
	
	// Query al database per sapere mail e hash della password
	$tabella = 'Utenti';
	$sql = "SELECT IdUtente, HashPassword FROM $tabella WHERE Mail = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();
	
	// Controllo password
	$hashed_password = $record['HashPassword'];
	if (!password_verify($password, $hashed_password)) {
		return false;
	}
	$_SESSION['id'] = $record['IdUtente'];
	$_SESSION['tipo'] = get_type($record['IdUtente']);
	
	return true;
	// da aggiungere 2FA
}

// Controllo del tipo dell'utente ('studente', 'azienda', 'admin'
function get_type($id) {
	global $conn;
	$sql = 'SELECT idUtente FROM aziende WHERE idUtente = ?';
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		return 'azienda';
	} else {
		return 'studente';
	}
}

function check_password($id, $password) {
	global $conn;
	$sql = 'SELECT HashPassword FROM Utenti WHERE IdUtente = ?';
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$record = $result->fetch_assoc();
	
	// Controllo della password
	$hashed_password = $record['HashPassword'];
	return password_verify($password, $hashed_password);
}

function check_credentials($id = null, $password = null) {
	if(isset($id)) {
		if(isset($password)) {
			if(check_password($id, $password)) {
				return $id;
			}
		} else {
			if($id == $_SESSION['id']) {
				return $id;
			}
		}
	} else if(isset($_SESSION['id'])) {
		return $_SESSION['id'];
	}
	return null;
}

function get_account($id = null) {
	if($id == null) {
		$logged = false;
	} else {
		$logged = check_credentials($id, null) != null;
	}

	return get_utente($id, $logged);
}

function get_utente($id = null, $logged = null) {
	
	if(isset($id)) {
		$tables = [Table::Utenti];
		$type = get_type($id);
		switch($type) {
			case 'studente': 
				$tables[] = Table::Studenti; 
				$join_arg = Arg::IdStudente;
				break;
			case 'azienda': 
				$tables[] = Table::Aziende;
				$join_arg = Arg::IdAzienda; 
				break;
		}

		$result = Query_select($tables, null, [Arg::IdUtente], [$id], [Arg::IdUtente], [$join_arg]);
		if($result) {
			$visualizza = query_select([Table::Utenti], [Arg::VisualizzaMail, Arg::VisualizzaTelefono], [Arg::IdUtente], [$id])->fetch_assoc();
			$record = $result->fetch_assoc();
			foreach($record as $attr => $value) {
				switch(Arg::fromDb($tables, $attr)) {
					case Arg::Email: 
						if(!$logged && $visualizza[Arg::VisualizzaMail->info()['dbName']] == 0) {
							unset($record[$attr]);
						} 
						break;
					case Arg::Telefono: 
						if(!$logged && $visualizza[Arg::VisualizzaTelefono->info()['dbName']] == 0) {
							unset($record[$attr]);
						} 
						break;
					case Arg::VisualizzaMail:
					case Arg::VisualizzaTelefono:
					case Arg::UtentePassword:
						unset($record[$attr]);
						break;
				}
			}
			$jsonArray = Arg::toJsonArray($tables, $record);
			$jsonArray['tipo'] = $type;
			return $jsonArray;
		} else {
			return false;
		}
	} else {
		$result = Query_select([Table::Utenti], [Arg::IdUtente]);
		while ($row = $result->fetch_assoc()) {
			$ids[] = $row[Arg::IdUtente->info()['dbName']];
		}
		foreach ($ids as $id) {
			$result = get_utente($id, $logged);
			if(!$result) {
				return false;
			}
			$results[] = $result;
		}
		return $results;
	}
}

function update_account($id = null, $password = null, $data) {
	if(check_credentials($id, $password) == null) {
		unauthorized_error();
	}
	
	global $conn;
	$conn->begin_transaction();
	try {
		$result = update_utente($id, $data);
	} catch (mysqli_sql_exception $e) {
		$e->getMessage();
		$result = false;
	}
	if($result) {
		$conn->commit();
	} else {
		$conn->rollback();
	}
	return $result;
}

function update_utente($id, $data) {
	$more_attr = false;
	foreach($data as $attr => $value) {
		$arg = Arg::fromJson([Table::Utenti], $attr);
		if($arg != null) {
			if($arg == Arg::UtentePassword) {
				$value = password_hash($value, PASSWORD_DEFAULT);
			}
			$attr_list[] = $arg;
			$var_list[] = $value;
		} else {
			$more_attr = true;
		}
	}
	
	if(isset($attr_list)) {
		$result = query_update(Table::Utenti, $attr_list, $var_list, [Arg::IdUtente], [$id]);
		if(!$result) {
			return false;
		}
	}
	
	if($more_attr) {
		$type = get_type($id);
		if($type == 'studente') {
			return update_studente($id, $data);
		} else if($type == 'azienda') {
			return update_azienda($id, $data);
		}
	} else {
		return $result;
	}
}

// Logout dall'account
function logout(){
	
	// Verifica che l'utente sia loggato
	if(!isset($_SESSION['id'])) {
		return false;
	}
	
	unset($_SESSION['id']);
	unset($_SESSION['tipo']);
	return true;
}

function delete_account($id, $password) {
	
	// Query per ottenere la password
	if(!check_password($id, $password)) {
		return false;
	}
	
	global $conn;
	
	// Eliminazione dell'account
	$sql = 'DELETE FROM Utenti WHERE IdUtente = ?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('i', $id);
	if ($stmt->execute()) {
		session_destroy();
		return true;
	}
	return false;
}
?>
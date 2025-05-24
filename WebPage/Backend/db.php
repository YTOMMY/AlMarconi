<?php	//Per connettersi al databases

$host = 'localhost';
$dbname = 'AlMarconi';
$username = 'root';
$password = '';

// Avvio della connessione
$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_errno) {
	die('Connessione non riuscita: ' . $conn->connect_error);
}

$conn->set_charset('utf8');

/**
 * @param array<Table> $tables
 * @param array<Arg>|null $select_args
 * @param array<Arg>|null $cond_args
 * @param array<Arg>|null $left_join_args
 * @param array<Arg>|null $right_join_args
*/
function query_select(array $tables, array|null $select_args = null, array|null $cond_args = null, array|null $cond_values = null, array|null $left_join_args = null, $right_join_args = null): bool|mysqli_result {
	global $conn;
	
	foreach($tables as &$table) {
		$table = $table->value;
	}
	unset($table);
	
	if(isset($select_args)) {
		foreach($select_args as &$arg) {
			$arg = $arg->toQuery();
		}
		unset($arg);
	} else {
		$select_args = ['*'];
	}
	
	if(isset($left_join_args) && isset($right_join_args)) {
		for ($i = 0; $i < count($left_join_args); $i++) {
			$cond[] = $left_join_args[$i]->toQuery() . ' = ' . $right_join_args[$i]->toQuery();
		}
	}
	
	if(isset($cond_args)) {
		$param_type = '';
		foreach($cond_args as $arg) {
			$cond[] = $arg->toQuery() . ' = ?';
			$param_type .= $arg->info()['type'];
		}

		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . implode(', ', $tables) . ' WHERE ' . implode(' AND ', $cond) . ';';

		$stmt = $conn->prepare($sql);
		$stmt->bind_param($param_type, ...$cond_values);
	} else {
		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . implode(', ', $tables);
		if(isset($cond)) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}
		$sql .= ';';
		$stmt = $conn->prepare($sql);
	}
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $insert_args
*/
function query_insert(Table $table, array $insert_args, array $insert_values): bool {
	global $conn;
	
	$param_type = '';
	foreach($insert_args as &$arg) {
		$insert_placeholder[] = '?';
		$param_type .= $arg->info()['type'];
		$arg = $arg->info()['dbName'];
	}
	unset($arg);

	$sql = 'INSERT INTO '. $table->value . '(' . implode(', ', $insert_args) . ') VALUES(' . implode(', ', $insert_placeholder) . ');'; 

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$insert_values);
	$stmt->execute();

	return $stmt->affected_rows > 0;
}

/**  
 * @param Arg[] $update_args
 * @param Arg[]|null $cond_args
*/
function query_update(Table $table, array $update_args, array $update_values, array $cond_args, array $cond_values): bool {
	global $conn;
	
	$param_type = '';
	$param_values = array_merge($update_values, $cond_values);
	foreach($update_args as &$arg) {
		$param_type .= $arg->info()['type'];
		$arg = $arg->info()['dbName'] . ' = ?';
	}
	unset($arg);
	foreach($cond_args as $arg) {
		$cond[] = $arg->info()['dbName'] . ' = ?';
		$param_type .= $arg->info()['type'];
	}

	$sql = 'UPDATE '. $table->value . ' SET ' . implode(', ', $update_args) . ' WHERE '. implode(' AND ', $cond) . ';';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$param_values);
	$stmt->execute();
	
	return $stmt->affected_rows > 0;
}

/**  
 * @param Arg[] $cond_args
*/
function query_delete(Table $table, array $cond_args, array $cond_values): bool {
	global $conn;
	
	$param_type = '';
	foreach($cond_args as $arg) {
		$cond[] = $arg->info()['dbName'] . ' = ?';
		$param_type .= $arg->info()['type'];
	}

	$sql = 'DELETE  FROM ' . $table->value. ' WHERE ' . implode(' AND ', $cond) . ';';

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$cond_values);
	$stmt->execute();
	return $stmt->affected_rows > 0;
}
?>
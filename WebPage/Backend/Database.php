<?php

require_once 'Table.php';
require_once 'Attr.php';

class Database{
    public function __construct() {
        $host = 'localhost';
        $dbname = 'AlMarconi';
        $username = 'root';
        $password = '';

        $conn = new mysqli($host, $username, $password, $dbname);
        if($conn->connect_errno) {
            die('Connessione non riuscita: ' . $conn->connect_error);
        }
    }

    function select(array $table, array|null $select_args = null, array|null $cond_args = null, array|null $cond_values = null, array|null $join_conditions = null) {
	global $conn;
	
	if(isset($select_args)) {
		foreach($select_args as &$arg) {
			$arg = $arg->value;
		}
		unset($arg);
	} else {
		$select_args = ['*'];
	}
	if(isset($cond_args)) {
		$param_type = '';
		foreach($cond_args as $arg) {
			$cond[] = $arg->value . ' = ?';
			$param_type .= $arg->getType();
		}

		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . $table->value . ' WHERE ' . implode(' AND ', $cond) . ';';

		$stmt = $conn->prepare($sql);
		$stmt->bind_param($param_type, ...$cond_values);
	} else {
		$sql = 'SELECT '. implode(', ', $select_args) . ' FROM ' . $table->value . ';';
		$stmt = $conn->prepare($sql);
	}
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $insert_args
*/
function insert(Table $table, array $insert_args, array $insert_values) {
	global $conn;
	
	$param_type = '';
	foreach($insert_args as $arg) {
		$insert_placeholder[] = '?';
		$param_type .= $arg->getType();
	}

	$sql = 'INSERT INTO '. $table . '(' . implode(', ', $insert_args) . ') VALUES(' . implode(', ', $insert_placeholder) . ');'; 

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$insert_values);
	$stmt->execute();
	return $stmt->get_result();
}

/**  
 * @param Arg[] $update_args
 * @param Arg[]|null $cond_args
*/
function update(Table $table, array $update_args, array $update_values, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	$param_values = array_merge($update_values, $cond_values);
	foreach($update_args as &$arg) {
		$param_type .= $arg->getType();
		$arg = $arg->value . ' = ?';
	}
	unset($arg);
	foreach($cond_args as $arg) {
		$cond[] = $arg->value . ' = ?';
		$param_type .= $arg->getType();
	}

	$sql = 'UPDATE '. $table->value . ' SET ' . implode(', ', $update_args) . ' WHERE '. implode(' AND ', $cond) . ';';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$param_values);
	
	return $stmt->execute();
}

/**  
 * @param Arg[] $cond_args
*/
function delete(Table $table, array $cond_args, array $cond_values) {
	global $conn;
	
	$param_type = '';
	foreach($cond_args as $arg) {
		$cond[] = $arg->value . ' = ?';
		$param_type .= $arg->getType();
	}

	$sql = 'DELETE  FROM ' . $table->value. ' WHERE ' . implode(' AND ', $cond) . ';';

	$stmt = $conn->prepare($sql);
	$stmt->bind_param($param_type, ...$cond_values);
	$stmt->execute();
	return $stmt->get_result();
}
}

?>
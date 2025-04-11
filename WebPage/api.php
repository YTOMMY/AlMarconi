<?php	// Per gestire le richieste GET, POST...

require_once 'backend/account.php';
require_once 'backend/diplomati.php';
require_once 'backend/aziende.php';

session_start();
$request_method = $_SERVER['REQUEST_METHOD'] ?? null;
$request_uri = $_SERVER['REQUEST_URI'] ?? null;
$input = file_get_contents('php://input') ?? null;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
while($uri[0] != 'api.php') {
	array_shift($uri);
}
array_shift($uri);

switch($uri[0]) {
	case 'login':
		switch($request_method) {
			case 'POST':
				check_content($input);
				$data = json_decode($input, true);
				
				if(login($data['email'], $data['password'])) {
					$id = $_SESSION['id'];
					$output = ['id' => $id, 'verificato' => is_verified($id), 'tipo' => get_type($id)];
				} else {
					$output = ['id' => 'null']; 
				}
				break;
			default:
				method_error(['POST']);
		}
		break;
	case 'register':
		switch($request_method) {
			case 'POST':
				check_content($input);
				$data = json_decode($input, true);
				
				if(create_account($data)) {
					$output = ['id' => $id, 'verificato' => is_verified($id), 'tipo' => get_type($id)];
				} else {
					$output = ['id' => 'null'];
				}
				break;
			default:
				method_error(['POST']);
		}
		break;
	default:
		not_found_error();
}

if(isset($output)) {
	echo json_encode($output);
}

function not_found_error() {
	header('HTTP/1.1 404 Not Found');
	echo 'Pagina non trovata';
	exit;
}

function method_error($consentiti) {
	$consentiti_string = implode(', ', $consentiti);
	header('HTTP/1.1 405 Method Not Allowed');
	header("Allow: $consentiti_string");
	echo "Metodo non consentito. I metodi consentiti sono: $consentiti_string";
	exit;
}

function check_content($input) {
	$content_type = $_SERVER['CONTENT_TYPE'] ?? null;
	if ($content_type != 'application/json' || $input == null) {
		header("HTTP/1.1 415 Unsupported Media Type");
		exit;
	}
}

/*
if ($request_method === 'POST') {
    // Se il contenuto è JSON
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        // Leggi i dati JSON dal corpo della richiesta
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);  // Decodifica il JSON in un array associativo
        
        echo "<strong>Dati JSON ricevuti tramite POST:</strong><br>";
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    } else {
        // Se i dati sono POST classici (non JSON)
        echo "<strong>Dati POST:</strong><br>";
        if (!empty($_POST)) {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
        } else {
            echo "Nessun dato POST trovato.<br>";
        }
    }
}
*/
?>
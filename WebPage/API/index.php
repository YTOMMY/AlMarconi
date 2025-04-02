<?php	// Per gestisce le richieste GET, POST...

require_once 'account.php';
require_once 'diplomati.php';
require_once 'aziende.php';

$request_method = $_SERVER['REQUEST_METHOD'] ?? null;
$request_uri = $_SERVER['REQUEST_URI'] ?? null;
$input = file_get_contents('php://input') ?? null;

$path = substr($request_uri, strlen('/api'));
$path_parts = explode('/', trim($path, '/'));

switch($path_parts) {
	case 'login':
		switch($request_method) {
			case 'POST':
				check_content($input);
				$data = json_decode($input, true);
				
				if(login($data['email'], $data['password'])) {
					$output = ['id' => 'null']; 
				} else {
					$id = $_SESSION['id'];
					$output = ['id' => $id, 'verificato' => is_verified($id)];
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
	if (content_type != 'application/json' || $input == null) {
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
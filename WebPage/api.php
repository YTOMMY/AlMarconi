<?php	// Per gestire le richieste

require_once 'backend/account.php';
require_once 'backend/studenti.php';
require_once 'backend/aziende.php';


// Avvio della sessione
session_start();

// aquisizione Method, URI e input
$request_method = $_SERVER['REQUEST_METHOD'] ?? null;
$request_uri = $_SERVER['REQUEST_URI'] ?? null;
$input = file_get_contents('php://input') ?? null;

// separazione di ogni componente dell'uri dopo '/api.php'
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
while($uri[0] != 'api.php') {
	array_shift($uri);
}
array_shift($uri);

// scelta del web service
switch($uri[0]) {
	
	// Login
	case 'login':
		switch($request_method) {
			case 'POST':
				check_content($input);
				$data = json_decode($input, true);
				
				if(login($data['email'], $data['password'])) {
					$id = $_SESSION['id'];
					$output = ['id' => $id, 'verificato' => is_verified($id), 'tipo' => get_type($id)];
					if($output['tipo'] == 'studente') {
						$datiStudente = getStudente();
						$output['nome'] = $datiStudente['Nome'] . ' ' . $datiStudente['Cognome'];
					}
					if($output['tipo'] == 'azienda') {
						$output['nome'] = getAzienda()['Nome'];
					}
				} else {
					$output = ['id' => 'null']; 
				}
				break;
			default:
				method_error(['POST']);
		}
		break;
			
	// Logout
	case 'logout':
		switch($request_method) {
			case 'POST':
				$output = ['logout' => logout()];
				break;
			default:
				method_error(['POST']);
		}
		break;
	
	// Gestione account
	case 'account':
		switch($request_method) {

			// Registrazione
			case 'POST':
				check_content($input);
				$data = json_decode($input, true);
				
				if(create_account($data)) {
					$id = $_SESSION['id'];
					$output = ['id' => $id, 'verificato' => is_verified($id), 'tipo' => get_type($id)];
					if($output['tipo'] == 'studente') {
						$datiStudente = getStudente();
						$output['nome'] = $datiStudente['Nome'] . ' ' . $datiStudente['Cognome'];
					}
					if($output['tipo'] == 'azienda') {
						$output['nome'] = getAzienda()['Nome'];
					}
				} else {
					$output = ['id' => 'null'];
				}
				break;
			
			// Elimina account
			case 'DELETE':
				check_content($input);
				$data = json_decode($input, true);
				$output = ['delete' => delete_account($data['password'])];
				break;
			default:
				method_error(['DELETE']);
		}
		break;

	// Web service non trovato
	default:
		not_found_error();
}

// Trasfomazione output in json e invio della risposta
if(isset($output)) {
	echo json_encode($output);
}

// errore: Web Service non trovato
function not_found_error() {
	header('HTTP/1.1 404 Not Found');
	echo 'Pagina non trovata';
	exit;
}

// errore: Metodo non corretto
function method_error($consentiti) {
	$consentiti_string = implode(', ', $consentiti);
	header('HTTP/1.1 405 Method Not Allowed');
	header("Allow: $consentiti_string");
	echo "Metodo non consentito. I metodi consentiti sono: $consentiti_string";
	exit;
}

// errore: Formato dati non corretto
function check_content($input) {
	$content_type = $_SERVER['CONTENT_TYPE'] ?? null;
	if ($content_type != 'application/json' || $input == null) {
		header("HTTP/1.1 415 Unsupported Media Type");
		exit;
	}
}
?>
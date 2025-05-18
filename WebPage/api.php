<?php	// Per gestire le richieste

require_once 'backend/account.php';
require_once 'backend/studenti.php';
require_once 'backend/aziende.php';
require_once 'backend/db.php';
require_once 'backend/Table.php';
require_once 'backend/Arg.php';


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
/*
print_r($uri);	
echo $request_method . '
';
if(isset($data)) {
	print_r($data);
}*/

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
						$output['nome'] = get_azienda()['Nome'];
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
		if(!isset($uri[2])){
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
							$output['nome'] = get_azienda()['Nome'];
						}
					} else {
						$output = ['id' => 'null'];
					}
					break;
				
				//Visualizza account
				case 'GET':
					if(isset($uri[1])) {
						$id = $uri[1];
					} else {
						$id = null;
					}
					
					$result = get_account($id);
					if(isset($id)) {
						$output = $result;
					} else {
						$output['account'] = $result;
					}
					if($output == false) {
						$output = ['esit' => false];
					} else {
						$output['esit'] = true;
					}
					break;
				
				//Modifica account
				case 'PATCH':
					check_content($input);
					$data = json_decode($input, true);
					if(!isset($uri[1])) {
						not_found_error();
					}
					$id = $uri[1];
					
					$password = $data['password'] ?? null;
					$data = $data['data'];
					
					$output = ['esit' => update_account($id, $password, $data)];
					break;
				
				// Elimina account
				case 'DELETE':
					if(!isset($uri[1])) {
						not_found_error();
					}
					check_content($input);
					$data = json_decode($input, true);
					$output = ['delete' => delete_account($uri[1], $data['password'])];
					break;
				default:
					method_error(['POST', 'GET', 'PATCH', 'DELETE']);
			}
		} else if($uri[2] == 'sede') {
			switch($request_method) {
				// Candidati
				
				default:
					method_error(['POST']);
			}
		} else {
			not_found_error();
		}
		break;
	case 'annuncio':
		if(!isset($uri[2])){
			switch($request_method) {

				// Visualizza annuncio
				case 'GET':
					check_content($input);
					$id = $uri[1];
					
					$output = get_annuncio($id);
					break;

				// Crea annuncio
				case 'POST':
					check_content($input);
					$data = json_decode($input, true);
					$output = ['esit' => create_annuncio($data)];
					break;

				// Modifica annuncio
				case 'PATCH':
					check_content($input);
					$data = json_decode($input, true);
					if(!isset($uri[1])) {
						not_found_error();
					}
					$id = $uri[1];
					$output = ['esit' => update_annuncio($id, $data['password'], $data['data'])];
					break;

				// Elimina annuncio
				case 'DELETE':
					if(!isset($uri[1])) {
						not_found_error();
					}
					$output = ['esit' => delete_annuncio($uri[1])];
					break;
				default:
					method_error(['GET', 'POST', 'PATCH', 'DELETE']);
			}
	 	} else if($uri[2] == 'candidati') {
			switch($request_method) {

				// Visualizza candidati
				case 'GET':
					check_content($input);
					$id = $uri[1];
					
					$output = get_candidati($id);
					if($output == false) {
						$output = ['esit' => false];
					} else {
						$output['esit'] = true;
					}
					break;
				
				// Candidarsi
				case 'POST':
					check_content($input);
					$id_annuncio = $uri[1];
					
					$output = ['esit' => candidarsi($id_annuncio)];
					break;
				default:
					method_error(['GET', 'POST']);
			}
		} else {
			not_found_error();
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

function unauthorized_error() {
	header('HTTP/1.1 401 Unauthorized');
	echo "Autenticazione richiesta";
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
		echo "Formato non supportato. Inviare i dati in formato JSON.";
		exit;
	}
}
?>
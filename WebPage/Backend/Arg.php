<?php

enum Arg{

    // Table::Admin

	case IdAdmin;
    case UsernameAdmin;
    case AdminPassword;

    // Table::Utenti

    case IdUtente;
    case Email;
    case Telefono;
    case UtentePassword;
    case TwoFA;
    case Verificato;
    case DataCreazione;
    case VisualizzaMail;
    case VisualizzaTelefono;

    // Table::Citta

    case IdCitta;
    case Cap;
    case NomeCitta;
    case Provincia;
    case Paese;

    // Table::Studenti

    case IdStudente;
    case CodiceFiscale;
    case NomeStudente;
    case Cognome;
    case Sesso;
    case DataNascita;
    case Nazionalita;
    case IndirizzoScolastico;
    case Voto;
    case DescrizioneStudente;
    case ResidenzaCitta;
    case ResidenzaVia;
    case ResidenzaCivico;
    case DomicilioCitta;
    case DomicilioVia;
    case DomicilioCivico;

    // Table::Abilita

    case IdAbilita;
    case DescrizioneAbilita;
    case Studente;

    // Table::Aziende

    case IdAzienda;
    case IVA;
    case NomeAzienda;
    case Settore;
    case NumeroDipendenti;
    case LinkEsterno;
    case DescrizioneAzienda;
    case ReferenteCodiceFiscale;
    case ReferenteNome;
    case ReferenteCognome;
    case ReferenteDataNascita;
    case SedeCitta;
    case SedeVia;
    case SedeCivico;

    // Table::Annunci

    case IdAnnuncio;
    case TipoContratto;
    case Mansione;
    case DescrizioneAnnuncio;
    case AreaDisciplinare;
    case AbilitaRichieste;
    case DataPubblicazione;
    case DataScadenza;
    case MaxIscrizioni;
    case AziendaAnnuncio;

	// Table::Candidarsi

	case AnnuncioCandidatura;
	case StudenteCandidatura;

    /**
     * @return array{dbName: string, table: Table, type: string, jsonName: string}|null
     */
    public function info(): ?array {
        switch ($this) {

            // Table::Admin

            case Arg::IdAdmin: return [
				'dbName' => 'IdAdmin', 
				'table' => Table::Admin,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::UsernameAdmin: return [
				'dbName' => 'Username', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];
            case Arg::AdminPassword: return [
				'dbName' => 'HashPassword', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];

            // Table::Utenti

            case Arg::IdUtente: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Utenti,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::Email: return [
				'dbName' => 'Mail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'email'];
            case Arg::Telefono: return [
				'dbName' => 'Telefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'telefono'];
            case Arg::UtentePassword: return [
				'dbName' => 'HashPassword', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'password'];
            case Arg::TwoFA: return [
				'dbName' => '2FA', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => '2FA'];
            case Arg::Verificato: return [
				'dbName' => 'Verificato', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Arg::DataCreazione: return [
				'dbName' => 'DataCreazione', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Arg::VisualizzaMail: return [
				'dbName' => 'VisualizzaMail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'visualizzaEmail'];
            case Arg::VisualizzaTelefono: return [
				'dbName' => 'VisualizzaTelefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'visualizzaTelefono'];
            
            // Table::Citta
            
            case Arg::IdCitta: return [
				'dbName' => 'IdCitta', 
				'table' => Table::Citta,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::Cap: return [
				'dbName' => 'Cap', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::NomeCitta: return [
				'dbName' => 'Nome', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::Provincia: return [
				'dbName' => 'Provincia', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::Paese: return [
				'dbName' => 'Paese', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            
            // Table::Studenti
            
            case Arg::IdStudente: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::CodiceFiscale: return [
				'dbName' => 'CodiceFiscale', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'cf'];
            case Arg::NomeStudente: return [
				'dbName' => 'Nome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nome'];
            case Arg::Cognome: return [
				'dbName' => 'Cognome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'cognome'];
            case Arg::Sesso: return [
				'dbName' => 'Sesso', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'sesso'];
            case Arg::DataNascita: return [
				'dbName' => 'DataNascita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nascita'];
            case Arg::Nazionalita: return [
				'dbName' => 'Nazionalita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nazionalita'];
            case Arg::IndirizzoScolastico: return [
				'dbName' => 'IndirizzoScolastico', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'indirizzo'];
            case Arg::Voto: return [
				'dbName' => 'Voto', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'voto'];
            case Arg::DescrizioneStudente: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::ResidenzaCitta: return [
				'dbName' => 'ResidenzaCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'cittaResidenza'];
            case Arg::ResidenzaVia: return [
				'dbName' => 'ResidenzaVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'viaResidenza'];
            case Arg::ResidenzaCivico: return [
				'dbName' => 'ResidenzaCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'civicoResidenza'];
            case Arg::DomicilioCitta: return [
				'dbName' => 'DomicilioCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'cittaDomicilio'];
            case Arg::DomicilioVia: return [
				'dbName' => 'DomicilioVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'viaDomicilio'];
            case Arg::DomicilioCivico: return [
				'dbName' => 'DomicilioCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'civicoDomicilio'];
           
            // Table::Abilita
           
            case Arg::IdAbilita: return [
				'dbName' => 'IdAbilita', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => '']; 
            case Arg::DescrizioneAbilita: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];       
            case Arg::Studente: return [
				'dbName' => 'Studente', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];

            // Table::Aziende

            case Arg::IdAzienda: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::IVA: return [
				'dbName' => 'IVA', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'iva'];
            case Arg::NomeAzienda: return [
				'dbName' => 'Nome', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'nomeAzienda'];
            case Arg::Settore: return [
				'dbName' => 'Settore', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'settore'];
            case Arg::NumeroDipendenti: return [
				'dbName' => 'NumeroDipendenti', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'dipendenti'];
            case Arg::LinkEsterno: return [
				'dbName' => 'Link', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'link'];
            case Arg::DescrizioneAzienda: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::ReferenteCodiceFiscale: return [
				'dbName' => 'ReferenteCodiceFiscale', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'cf'];
            case Arg::ReferenteNome: return [
				'dbName' => 'ReferenteNome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'nome'];
            case Arg::ReferenteCognome: return [
				'dbName' => 'ReferenteCognome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'cognome'];
            case Arg::ReferenteDataNascita: return [
				'dbName' => 'ReferenteDataNascita', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'nascita'];
            case Arg::SedeCitta: return [
				'dbName' => 'SedeCitta', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'cittaSede'];
            case Arg::SedeVia: return [
				'dbName' => 'SedeVia', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'viaSede'];
            case Arg::SedeCivico: return [
				'dbName' => 'SedeCivico', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'civicoSede'];

            // Table::Annunci

            case Arg::IdAnnuncio: return [
				'dbName' => 'IdAnnuncio', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::TipoContratto: return [
				'dbName' => 'TipoContratto', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'tipo'];
            case Arg::Mansione: return [
				'dbName' => 'Mansione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'mansione'];
            case Arg::DescrizioneAnnuncio: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::AreaDisciplinare: return [
				'dbName' => 'AreaDisciplinare', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'areaDisciplinare'];
            case Arg::AbilitaRichieste: return [
				'dbName' => 'AbilitaRichieste', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'abilita'];
            case Arg::DataPubblicazione: return [
				'dbName' => 'DataPubblicazione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'pubblicazione'];
            case Arg::DataScadenza: return [
				'dbName' => 'DataScadenza', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'scadenza'];
            case Arg::MaxIscrizioni: return [
				'dbName' => 'MaxIscrizioni', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'maxIscrizioni'];
            case Arg::AziendaAnnuncio : return [
				'dbName' => 'Azienda', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'azienda'];
			
			// Table::Candidarsi

			case Arg::AnnuncioCandidatura: return [
				'dbName' => 'IdAnnuncio',
				'table' => Table::Candidarsi,
				'type'=> 'i',
				'jsonName' => 'idAnnuncio'];
			case Arg::StudenteCandidatura: return [
				'dbName' => 'IdStudente',
				'table' => Table::Candidarsi,
				'type'=> 'i',
				'jsonName' => 'idStudente'];
            default: return null;
        }
    }

	/** 
     * @param Table[] $tables
    */
	public static function fromDb(array $tables, string $dbName): ?Arg {
		
        foreach($tables as $table) {
            $Args = Arg::cases();
            foreach($Args as $Arg) {
                $info = $Arg->info();
                if($info['table'] == $table && $info['dbName'] == $dbName) {
                    return $Arg;
                }
            }
        }
        return null;
	}

    /** 
     * @param Table[] $tables
    */
	public static function fromJson(array $tables, string $jsonName): ?Arg {
		
        foreach($tables as $table) {
            $Args = Arg::cases();
            foreach($Args as $Arg) {
                $info = $Arg->info();
                if($info['table'] == $table && $info['jsonName'] == $jsonName) {
                    return $Arg;
                }
            }
        }
        return null;
	}
	
	/** 
     * @param array<table> $tables
	 * @param array<string, mixed>|array<string> $jsonArgs
	 * @return array{args: array<Arg>, values: array}|null
    */
	public static function fromJsonArray(array $tables, array $jsonArgs): ?array {
		$Args = null;

		if(is_numeric(array_keys($jsonArgs)[0])) {
			foreach($jsonArgs as $jsonArg) {
				$jsonName = null;
				switch ($jsonArg) {
					case 'residenza': $jsonName = $jsonName ?? 'Residenza';
					case 'domicilio': $jsonName = $jsonName ?? 'Domicilio';
					case 'sede': $jsonName = $jsonName ?? 'Sede';
						$Args['args'][] = Arg::fromJson($tables, $jsonName . $jsonArg);
						break;
				}
				$Args['args'][] = Arg::fromJson($tables, $jsonArg);
			}
		} else {
			foreach($jsonArgs as $jsonArg => $jsonValue) {
				if(is_array($jsonValue)) {
					$jsonName = null;
					switch($jsonArg) {
						case 'residenza': $jsonName = $jsonName ?? 'Residenza';
						case 'domicilio': $jsonName = $jsonName ?? 'Domicilio';
						case 'sede': $jsonName = $jsonName ?? 'Sede';
							foreach($jsonValue as $arg => $value) {
								$Args['args'][] = Arg::fromJson($tables, $jsonArg . $jsonName);
								$Args['values'][] = $jsonValue;
							}
							break;
					}
				}
				$Args['args'][] = Arg::fromJson($tables, $jsonArg);
				$Args['values'][] = $jsonValue;
			}
		}
		return $Args;
	}

	/** 
     * @param array<table> $tables
	 * @param array<string, mixed> $args
    */
	public static function toJsonArray(array $tables, array $args): array|null {
		$array = null;
		foreach($args as $arg => $value) {
			switch($arg) {
				case Arg::ResidenzaCitta:
				case Arg::ResidenzaVia:
				case Arg::ResidenzaCivico:
					$array['Residenza'][str_replace("Residenza", "", Arg::fromDb($tables, $arg)->info()['jsonName'])] = $value;
					break;
				case Arg::DomicilioCitta:
				case Arg::DomicilioVia:
				case Arg::DomicilioCivico:
					$array['Domicilio'][str_replace("Domicilio", "", Arg::fromDb($tables, $arg)->info()['jsonName'])] = $value;
					break;
				case Arg::SedeCitta:
				case Arg::SedeVia:
				case Arg::SedeCivico:
					$array['Sede'][str_replace("Sede", "", Arg::fromDb($tables, $arg)->info()['jsonName'])] = $value;
					break;
				default: 
					$array[Arg::fromDb($tables, $arg)->info()['jsonName']] = $value; 
					break;
			}			
		}
		return $array;
	}

	public function toQuery() {
		return $this->info()['table']->value . '.' . $this->info()['dbName'];
	}
}

?>
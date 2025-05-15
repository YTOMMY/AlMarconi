<?php

require_once 'Table.php';

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
    case IdSede;

    // Table::Sedi

    case AziendaSede;
    case CittaSede;
    case ViaSede;
    case CivicoSede;
    case SedeLegale;

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
    case SedeAnnuncio;

    /**
     * @return array{dbName: string, table: Table, type: string, jsonName: string}|null
     */
    public function info(): ?array {
        switch ($this) {

            // Table::Admin

            case Arg::IdAdmin: return [
				'dbName' => Table::Admin->value . '.IdAdmin', 
				'table' => Table::Admin,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::UsernameAdmin: return [
				'dbName' => Table::Admin->value . '.Username', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];
            case Arg::AdminPassword: return [
				'dbName' => Table::Admin->value . '.HashPassword', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];

            // Table::Utenti

            case Arg::IdUtente: return [
				'dbName' => Table::Utenti . '.IdUtente', 
				'table' => Table::Utenti,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::Email: return [
				'dbName' => Table::Utenti . '.Mail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'email'];
            case Arg::Telefono: return [
				'dbName' => Table::Utenti . '.Telefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'telefono'];
            case Arg::UtentePassword: return [
				'dbName' => Table::Utenti . '.HashPassword', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'password'];
            case Arg::TwoFA: return [
				'dbName' => Table::Utenti . '.2FA', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => '2FA'];
            case Arg::Verificato: return [
				'dbName' => Table::Utenti . '.Verificato', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Arg::DataCreazione: return [
				'dbName' => Table::Utenti . '.DataCreazione', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Arg::VisualizzaMail: return [
				'dbName' => Table::Utenti . '.VisualizzaMail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'VisualizzaEmail'];
            case Arg::VisualizzaTelefono: return [
				'dbName' => Table::Utenti . '.VisualizzaTelefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => 'VisualizzaTelefono'];
            
            // Table::Citta
            
            case Arg::IdCitta: return [
				'dbName' => Table::Citta . '.IdCitta', 
				'table' => Table::Citta,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::Cap: return [
				'dbName' => Table::Citta . '.Cap', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::NomeCitta: return [
				'dbName' => Table::Citta . '.Nome', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::Provincia: return [
				'dbName' => Table::Citta . '.Provincia', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Arg::Paese: return [
				'dbName' => Table::Citta . '.Paese', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            
            // Table::Studenti
            
            case Arg::IdStudente: return [
				'dbName' => Table::Studenti . '.IdUtente', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::CodiceFiscale: return [
				'dbName' => Table::Studenti . '.CodiceFiscale', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'cf'];
            case Arg::NomeStudente: return [
				'dbName' => Table::Studenti . '.Nome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nome'];
            case Arg::Cognome: return [
				'dbName' => Table::Studenti . '.Cognome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'cognome'];
            case Arg::Sesso: return [
				'dbName' => Table::Studenti . '.Sesso', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'sesso'];
            case Arg::DataNascita: return [
				'dbName' => Table::Studenti . '.DataNascita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nascita'];
            case Arg::Nazionalita: return [
				'dbName' => Table::Studenti . '.Nazionalita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'nazionalita'];
            case Arg::IndirizzoScolastico: return [
				'dbName' => Table::Studenti . '.IndirizzoScolastico', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Arg::Voto: return [
				'dbName' => Table::Studenti . '.Voto', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'voto'];
            case Arg::DescrizioneStudente: return [
				'dbName' => Table::Studenti . '.Descrizione', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::ResidenzaCitta: return [
				'dbName' => Table::Studenti . '.ResidenzaCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'cittaResidenza'];
            case Arg::ResidenzaVia: return [
				'dbName' => Table::Studenti . '.ResidenzaVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'viaResidenza'];
            case Arg::ResidenzaCivico: return [
				'dbName' => Table::Studenti . '.ResidenzaCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'civicoResidenza'];
            case Arg::DomicilioCitta: return [
				'dbName' => Table::Studenti . '.DomicilioCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'cittaDomicilio'];
            case Arg::DomicilioVia: return [
				'dbName' => Table::Studenti . '.DomicilioVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => 'viaDomicilio'];
            case Arg::DomicilioCivico: return [
				'dbName' => Table::Studenti . '.DomicilioCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => 'civicoDomicilio'];
           
            // Table::Abilita
           
            case Arg::IdAbilita: return [
				'dbName' => Table::Abilita . '.IdAbilita', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => '']; 
            case Arg::DescrizioneAbilita: return [
				'dbName' => Table::Abilita . '.Descrizione', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];       
            case Arg::Studente: return [
				'dbName' => Table::Abilita . '.Studente', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];

            // Table::Aziende

            case Arg::IdAzienda: return [
				'dbName' => Table::Aziende . '.IdUtente', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::IVA: return [
				'dbName' => Table::Aziende . '.IVA', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'iva'];
            case Arg::NomeAzienda: return [
				'dbName' => Table::Aziende . '.Nome', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'nomeAzienda'];
            case Arg::Settore: return [
				'dbName' => Table::Aziende . '.Settore', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'settore'];
            case Arg::NumeroDipendenti: return [
				'dbName' => Table::Aziende . '.NumeroDipendenti', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => 'dipendenti'];
            case Arg::LinkEsterno: return [
				'dbName' => Table::Aziende . '.Link', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'link'];
            case Arg::DescrizioneAzienda: return [
				'dbName' => Table::Aziende . '.Descrizione', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::ReferenteCodiceFiscale: return [
				'dbName' => Table::Aziende . '.ReferenteCodiceFiscale', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'cf'];
            case Arg::ReferenteNome: return [
				'dbName' => Table::Aziende . '.ReferenteNome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'nome'];
            case Arg::ReferenteCognome: return [
				'dbName' => Table::Aziende . '.ReferenteCognome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'cognome'];
            case Arg::ReferenteDataNascita: return [
				'dbName' => Table::Aziende . '.ReferenteDataNascita', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => 'nascita'];

            // Table::Sedi

            case Arg::IdSede: return [
				'dbName' => Table::Aziende . '.IdSede', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::AziendaSede: return [
				'dbName' => Table::Sedi . '.Azienda', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::CittaSede: return [
				'dbName' => Table::Sedi . '.Citta', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::ViaSede: return [
				'dbName' => Table::Sedi . '.Via', 
				'table' => Table::Sedi,
				'type' => 's',
				'jsonName' => ''];
            case Arg::CivicoSede: return [
				'dbName' => Table::Sedi . '.Civico', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Arg::SedeLegale: return [
				'dbName' => Table::Sedi . '.Legale', 
				'table' => Table::Sedi,
				'type' => 's',
				'jsonName' => ''];

            // Table::Annunci

            case Arg::IdAnnuncio: return [
				'dbName' => Table::Annunci . '.IdAnnuncio', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'id'];
            case Arg::TipoContratto: return [
				'dbName' => Table::Annunci . '.TipoContratto', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'tipo'];
            case Arg::Mansione: return [
				'dbName' => Table::Annunci . '.Mansione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'mansione'];
            case Arg::DescrizioneAnnuncio: return [
				'dbName' => Table::Annunci . '.Descrizione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'descrizione'];
            case Arg::AreaDisciplinare: return [
				'dbName' => Table::Annunci . '.AreaDisciplinare', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'areaDisciplinare'];
            case Arg::AbilitaRichieste: return [
				'dbName' => Table::Annunci . '.AbilitaRichieste', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'abilita'];
            case Arg::DataPubblicazione: return [
				'dbName' => Table::Annunci . '.DataPubblicazione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'pubblicazione'];
            case Arg::DataScadenza: return [
				'dbName' => Table::Annunci . '.DataScadenza', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => 'scadenza'];
            case Arg::MaxIscrizioni: return [
				'dbName' => Table::Annunci . '.MaxIscrizioni', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'maxIscrizioni'];
            case Arg::AziendaAnnuncio : return [
				'dbName' => Table::Annunci . '.Azienda', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'azienda'];
            case Arg::SedeAnnuncio : return [
				'dbName' => Table::Annunci . '.Sede', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => 'sede'];
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
                if($info['table'] == $table && $info['json'] == $jsonName) {
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
				default: 
					$array[Arg::fromDb($tables, $arg)->info()['jsonName']] = $value; 
					break;
			}			
		}
		return $array;
	}
}

?>
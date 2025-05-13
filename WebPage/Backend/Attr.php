<?php

require_once 'Table.php';

enum Attr: array{

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
    case AziendaAnnucio;
    case SedeAnnucio;

    /**
     * @return array{dbName: string, table: Table, type: string, jsonName: string}|null
     */
    public function info(): ?array {
        switch ($this) {

            // Table::Admin

            case Attr::IdAdmin: return [
				'dbName' => 'IdAdmin', 
				'table' => Table::Admin,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::UsernameAdmin: return [
				'dbName' => 'Username', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];
            case Attr::AdminPassword: return [
				'dbName' => 'HashPassword', 
				'table' => Table::Admin,
				'type' => 's',
				'jsonName' => ''];

            // Table::Utenti

            case Attr::IdUtente: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Utenti,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::Email: return [
				'dbName' => 'Mail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Telefono: return [
				'dbName' => 'Telefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::UtentePassword: return [
				'dbName' => 'HashPassword', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::TwoFA: return [
				'dbName' => '2FA', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Verificato: return [
				'dbName' => 'Verificato', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DataCreazione: return [
				'dbName' => 'DataCreazione', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::VisualizzaMail: return [
				'dbName' => 'VisualizzaMail', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::VisualizzaTelefono: return [
				'dbName' => 'VisualizzaTelefono', 
				'table' => Table::Utenti,
				'type' => 's',
				'jsonName' => ''];
            
            // Table::Citta
            
            case Attr::IdCitta: return [
				'dbName' => 'IdCitta', 
				'table' => Table::Citta,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::Cap: return [
				'dbName' => 'Cap', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Attr::NomeCitta: return [
				'dbName' => 'Nome', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Provincia: return [
				'dbName' => 'Provincia', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Paese: return [
				'dbName' => 'Paese', 
				'table' => Table::Citta,
				'type' => 's',
				'jsonName' => ''];
            
            // Table::Studenti
            
            case Attr::IdStudente: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::CodiceFiscale: return [
				'dbName' => 'CodiceFiscale', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::NomeStudente: return [
				'dbName' => 'Nome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Cognome: return [
				'dbName' => 'Cognome', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Sesso: return [
				'dbName' => 'Sesso', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DataNascita: return [
				'dbName' => 'DataNascita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Nazionalita: return [
				'dbName' => 'Nazionalita', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::IndirizzoScolastico: return [
				'dbName' => 'IndirizzoScolastico', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Voto: return [
				'dbName' => 'Voto', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DescrizioneStudente: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ResidenzaCitta: return [
				'dbName' => 'ResidenzaCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::ResidenzaVia: return [
				'dbName' => 'ResidenzaVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ResidenzaCivico: return [
				'dbName' => 'ResidenzaCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::DomicilioCitta: return [
				'dbName' => 'DomicilioCitta', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::DomicilioVia: return [
				'dbName' => 'DomicilioVia', 
				'table' => Table::Studenti,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DomicilioCivico: return [
				'dbName' => 'DomicilioCivico', 
				'table' => Table::Studenti,
				'type' => 'i',
				'jsonName' => ''];
           
            // Table::Abilita
           
            case Attr::IdAbilita: return [
				'dbName' => 'IdAbilita', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => '']; 
            case Attr::DescrizioneAbilita: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];       
            case Attr::Studente: return [
				'dbName' => 'Studente', 
				'table' => Table::Abilita,
				'type' => 'i',
				'jsonName' => ''];

            // Table::Aziende

            case Attr::IdAzienda: return [
				'dbName' => 'IdUtente', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::IVA: return [
				'dbName' => 'IVA', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::NomeAzienda: return [
				'dbName' => 'Nome', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::Settore: return [
				'dbName' => 'Settore', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::NumeroDipendenti: return [
				'dbName' => 'NumeroDipendenti', 
				'table' => Table::Aziende,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::LinkEsterno: return [
				'dbName' => 'Link', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DescrizioneAzienda: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ReferenteCodiceFiscale: return [
				'dbName' => 'ReferenteCodiceFiscale', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ReferenteNome: return [
				'dbName' => 'ReferenteNome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ReferenteCognome: return [
				'dbName' => 'ReferenteCognome', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::ReferenteDataNascita: return [
				'dbName' => 'ReferenteDataNascita', 
				'table' => Table::Aziende,
				'type' => 's',
				'jsonName' => ''];
            case Attr::IdSede: return [
				'dbName' => 'IdSede', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];

            // Table::Sedi

            case Attr::AziendaSede: return [
				'dbName' => 'Azienda', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::CittaSede: return [
				'dbName' => 'Citta', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::ViaSede: return [
				'dbName' => 'Via', 
				'table' => Table::Sedi,
				'type' => 's',
				'jsonName' => ''];
            case Attr::CivicoSede: return [
				'dbName' => 'Civico', 
				'table' => Table::Sedi,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::SedeLegale: return [
				'dbName' => 'Legale', 
				'table' => Table::Sedi,
				'type' => 's',
				'jsonName' => ''];

            // Table::Annunci

            case Attr::IdAnnuncio: return [
				'dbName' => 'IdAnnuncio', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::TipoContratto: return [
				'dbName' => 'TipoContratto', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::Mansione: return [
				'dbName' => 'Mansione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DescrizioneAnnuncio: return [
				'dbName' => 'Descrizione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::AreaDisciplinare: return [
				'dbName' => 'AreaDisciplinare', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::AbilitaRichieste: return [
				'dbName' => 'AbilitaRichieste', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DataPubblicazione: return [
				'dbName' => 'DataPubblicazione', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::DataScadenza: return [
				'dbName' => 'DataScadenza', 
				'table' => Table::Annunci,
				'type' => 's',
				'jsonName' => ''];
            case Attr::MaxIscrizioni: return [
				'dbName' => 'MaxIscrizioni', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::AziendaAnnucio : return [
				'dbName' => 'Azienda', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => ''];
            case Attr::SedeAnnucio : return [
				'dbName' => 'Sede', 
				'table' => Table::Annunci,
				'type' => 'i',
				'jsonName' => ''];
            default: return null;
        }
    }

    /** 
     * @param Table[] $tables
    */
	public static function fromJson(array $tables, string $jsonName): ?Attr {
		
        foreach($tables as $table) {
            $attrs = Attr::cases();
            foreach($attrs as $attr) {
                $info = $attr->info();
                if($info['table'] == $table && $info['json'] == $jsonName) {
                    return $attr;
                }
            }
        }
        return null;
        /*
        switch ($table) {
			case Table::Admin: switch($value) {
				
				default: return null;
			}
			case Table::Utenti: switch($value) {
				case 'id': return Arg::IdUtente;
				case 'email': return Arg::Email;
				case 'password': return Arg::Password;
				case 'telefono': return Arg::Telefono;
				case '2FA': return Arg::TwoFA;
				case 'visualizzaEmail': return Arg::VisualizzaMail;
				case 'visualizzaTelefono': return Arg::VisualizzaTelefono;
				default: return null;
			}
			case Table::Citta: switch($value) {
				
				default: return null;
			}
			case Table::Studenti: switch($value) {
				case 'id': return Arg::IdUtente;
				case 'cf': return Arg::CodiceFiscale;
				case 'nome': return Arg::Nome;
				case 'cognome': return Arg::Cognome;
				case 'sesso': return Arg::Sesso;
				case 'nascita': return Arg::DataNascita;
				case 'nazionalita': return Arg::Nazionalita;
				case 'indirizzo': return Arg::IndirizzoScolastico;
				case 'voto': return Arg::Voto;
				case 'descrizione': return Arg::Descrizione;
				case 'residenza': return [Arg::ResidenzaCitta, Arg::ResidenzaVia, Arg::ResidenzaCivico];
				case 'domicilio': return [Arg::DomicilioCitta, Arg::DomicilioVia, Arg::DomicilioCivico];
				/*case '': return Arg::IdAbilita;
				case '': return Arg::Studente;
				default: return null;
			}
			case Table::Aziende: switch($value) {
				case 'id': return Arg::IdAnnuncio;
				case 'iva': return Arg::IVA;
				case 'nomeAzienda': return Arg::Nome;
				case 'settore': return Arg::Settore;
				case 'dipendenti': return Arg::NumeroDipendenti;
				case 'link': return Arg::LinkEsterno;
				case 'cf': return Arg::ReferenteCodiceFiscale;
				case 'nome': return Arg::ReferenteNome;
				case 'cognome': return Arg::ReferenteCognome;
				case 'nascita': return Arg::ReferenteDataNascita;
				default: return null;
			}
			case Table::Annunci: switch($value) {
				case 'id': return Arg::IdAnnuncio;
				case 'tipo': return Arg::TipoContratto;
				case 'mansione': return Arg::Mansione;
				case 'descrizione': return Arg::Descrizione;
				case 'areaDisciplinare': return Arg::AreaDisciplinare;
				case 'abilita': return Arg::AbilitaRichieste;
				case 'pubblicazione': return Arg::DataPubblicazione;
				case 'scadenza': return Arg::DataScadenza;
				case 'maxIscrizioni': return Arg::MaxIscrizioni;
				case 'azienda': return Arg::Azienda;
				case 'sede': return Arg::Sede;
				default: return null;
			}
			default: return null;
		}*/
	}
}

?>
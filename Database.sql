CREATE DATABASE AlMarconi;
USE AlMarconi;

CREATE TABLE Admin(
	IdAdmin INT(2) AUTO_INCREMENT NOT NULL,
	Username VARCHAR(24) UNIQUE NOT NULL,
	HashPassword VARCHAR(60) NOT NULL,

	PRIMARY KEY(IdAdmin)
);
CREATE TABLE Utenti(
	IdUtente INT(6) AUTO_INCREMENT NOT NULL,
	Mail VARCHAR(255) NOT NULL UNIQUE,
	Telefono VARCHAR(16) UNIQUE,
	HashPassword VARCHAR(60) NOT NULL,
	2FA BIT NOT NULL DEFAULT 0,
	Verificato BIT NOT NULL DEFAULT 0,
	DataCreazione DATE NOT NULL DEFAULT CURDATE(),
	VisualizzaMail BIT(1) NOT NULL DEFAULT 0,
	VisualizzaTelefono BIT(1) NOT NULL DEFAULT 0,

	PRIMARY KEY(IdUtente)
);
CREATE TABLE Citta(
	IdCitta INT(5) AUTO_INCREMENT NOT NULL,
	Cap INT(5) NOT NULL,
	Nome VARCHAR(50) NOT NULL,
	Provincia VARCHAR(2) NOT NULL,
	Paese VARCHAR(30) NOT NULL,

	PRIMARY KEY(IdCitta)
);
CREATE TABLE Studenti(
	IdUtente INT(6) NOT NULL,
	CodiceFiscale VARCHAR(16) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Cognome VARCHAR(50) NOT NULL,
	Sesso VARCHAR(1),
	DataNascita DATE NOT NULL,
	Nazionalita VARCHAR(30) NOT NULL,
	IndirizzoScolastico VARCHAR(30) NOT NULL,
	Voto INT(3) NOT NULL,
	Descrizione TEXT,
	ResidenzaCitta INT(5) NOT NULL,
	ResidenzaVia INT(7) NOT NULL,
	ResidenzaCivico INT(7) NOT NULL,
	DomicilioCitta INT(5) NOT NULL,
	DomicilioVia INT(7),
	DomicilioCivico INT(7),
	
	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente),
	FOREIGN KEY(ResidenzaCitta) REFERENCES Citta(IdCitta),
	FOREIGN KEY(DomicilioCitta) REFERENCES Citta(IdCitta)
);
CREATE TABLE Abilita(
	IdAbilita INT(7) AUTO_INCREMENT NOT NULL,
	Descrizione TEXT NOT NULL,
	Studente INT(6) NOT NULL,

	PRIMARY KEY(IdAbilita),
	FOREIGN KEY(Studente) REFERENCES Studenti(IdUtente)
);
CREATE TABLE Aziende(
	IdUtente INT(6) NOT NULL,
	IVA INT(11) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Settore VARCHAR(30) NOT NULL,
	NumeroDipendenti INT(6),
	Link TEXT,
	Descrizione TEXT,
	ReferenteCodiceFiscale VARCHAR(16) NOT NULL UNIQUE,
	ReferenteNome VARCHAR(50) NOT NULL,
	ReferenteCognome VARCHAR(50) NOT NULL,
	ReferenteDataNascita DATE NOT NULL,

	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente)
);
CREATE TABLE Sedi(
	IdSede INT(6) NOT NULL AUTO_INCREMENT,
	Azienda INT(6) NOT NULL,
	Citta INT(5) NOT NULL,
	Via VARCHAR(30) NOT NULL,
	Civico INT(6) NOT NULL,
	Legale BIT(1) NOT NULL,
	
	PRIMARY KEY(IdSede),
	FOREIGN KEY(Azienda) REFERENCES Aziende(IdUtente),
	FOREIGN KEY(Citta) REFERENCES Citta(IdCitta)
);
CREATE TABLE Annunci(
	IdAnnuncio INT(6) AUTO_INCREMENT NOT NULL,
	TipoContratto VARCHAR(50) NOT NULL,
	Mansione VARCHAR(30) NOT NULL,
	Descrizione TEXT NOT NULL,
	AreaDisciplinare VARCHAR(30) NOT NULL,
	AbilitaRichieste TEXT,
	DataPubblicazione DATE NOT NULL DEFAULT CURDATE(),
	DataScadenza DATE NULL,
	MaxIscrizioni INT(6),
	Azienda INT(6) NOT NULL,
	Sede INT(6) NOT NULL,

	PRIMARY KEY(IdAnnuncio),
	FOREIGN KEY(Azienda) REFERENCES Aziende(IdUtente),
	FOREIGN KEY(Sede) REFERENCES Sedi(IdSede)
);
CREATE TABLE Candidarsi(
	IdStudente INT(6) NOT NULL,
	IdAnnuncio INT(6) NOT NULL,
	Data DATE NOT NULL DEFAULT CURDATE(),
	
	PRIMARY KEY(IdStudente, IdAnnuncio),
	FOREIGN KEY (IdStudente) REFERENCES Studenti(IdUtente),
	FOREIGN KEY (IdAnnuncio) REFERENCES Annunci(IdAnnuncio)
);

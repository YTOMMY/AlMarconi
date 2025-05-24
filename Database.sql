CREATE DATABASE AlMarconi;
USE AlMarconi;

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
	ResidenzaCitta VARCHAR(50) NOT NULL,
	ResidenzaVia VARCHAR(50) NOT NULL,
	ResidenzaCivico INT(7) NOT NULL,
	DomicilioCitta VARCHAR(50),
	DomicilioVia VARCHAR(50),
	DomicilioCivico INT(7),
	
	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente) ON DELETE CASCADE
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
	SedeCitta VARCHAR(50) NOT NULL,
	SedeVia VARCHAR(50) NOT NULL,
	SedeCivico INT(7) NOT NULL,

	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente) ON DELETE CASCADE
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

	PRIMARY KEY(IdAnnuncio),
	FOREIGN KEY(Azienda) REFERENCES Aziende(IdUtente) ON DELETE CASCADE
);
CREATE TABLE Candidarsi(
	IdStudente INT(6) NOT NULL,
	IdAnnuncio INT(6) NOT NULL,
	Data DATE NOT NULL DEFAULT CURDATE(),
	
	PRIMARY KEY(IdStudente, IdAnnuncio),
	FOREIGN KEY (IdStudente) REFERENCES Studenti(IdUtente) ON DELETE CASCADE,
	FOREIGN KEY (IdAnnuncio) REFERENCES Annunci(IdAnnuncio) ON DELETE CASCADE
);
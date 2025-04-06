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
	Telefono VARCHAR(16) NULL UNIQUE,
	HashPassword VARCHAR(60) NOT NULL,
	2FA BIT NOT NULL DEFAULT 1,
	Verificato BIT NOT NULL DEFAULT 0,
	DataCreazione DATE NOT NULL,

	PRIMARY KEY(IdUtente)
);
CREATE TABLE Citta(
	IdCitta INT(5) AUTO_INCREMENT NOT NULL,
	Cap INT(5) NOT NULL,
	Nome VARCHAR(50) NOT NULL,
	Paese VARCHAR(30) NOT NULL,

	PRIMARY KEY(IdCitta)
);
CREATE TABLE Indirizzi(
	IdIndirizzo INT(7)	NOT NULL AUTO_INCREMENT,
	Via VARCHAR(30) NOT NULL,
	Civico INT(6) NOT NULL,
	Citta INT(6) NOT NULL,

	PRIMARY KEY(IdIndirizzo),
	FOREIGN KEY(Citta) REFERENCES Citta(IdCitta)	
);
CREATE TABLE Studenti(
	IdUtente INT(6) NOT NULL,
	CodiceFiscale VARCHAR(16) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Cognome VARCHAR(50) NOT NULL,
	Sesso VARCHAR(1) NULL,
	DataNascita DATE NOT NULL,
	IndirizzoScolastico VARCHAR(30) NOT NULL,
	Voto INT(3) NOT NULL,
	Citta INT(6) NOT NULL,
	Domicilio INT(6) NULL,
	Residenza INT(6) NOT NULL,
	
	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente),
	FOREIGN KEY(Citta) REFERENCES Citta(IdCitta),
	FOREIGN KEY(Domicilio) REFERENCES Indirizzi(IdIndirizzo),
	FOREIGN KEY(Residenza) REFERENCES Indirizzi(IdIndirizzo)
);
CREATE TABLE Abilita(
	IdAbilita INT(7) AUTO_INCREMENT NOT NULL,
	Descrizione TEXT NOT NULL,
	IdUtente INT(6) NOT NULL,

	PRIMARY KEY(IdAbilita),
	FOREIGN KEY(IdUtente) REFERENCES Studenti(IdUtente)
);
CREATE TABLE Referenti(
	CodiceFiscale VARCHAR(16) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Cognome VARCHAR(50) NOT NULL,
	DataNascita DATE NOT NULL,
	Ruolo VARCHAR(30) NOT NULL,
	Citta INT(6) NOT NULL,	

	PRIMARY KEY(CodiceFiscale),	
	FOREIGN KEY(Citta) REFERENCES Citta(IdCitta)	
);
CREATE TABLE Aziende(
	IdUtente INT(6) NOT NULL,
	IVA INT(11) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Settore VARCHAR(30) NOT NULL,
	NumeroDipendenti INT(6) NULL,
	Link TEXT NULL,
	Descrizione TEXT NULL,
	Referente VARCHAR(16) NOT NULL,

	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente),
	FOREIGN KEY(Referente) REFERENCES Referenti(CodiceFiscale)
);
CREATE TABLE Annunci(
	IdAnnuncio INT(6) AUTO_INCREMENT NOT NULL,
	TipoContratto VARCHAR(50) NOT NULL,
	Mansione VARCHAR(30) NOT NULL,
	Descrizione TEXT NOT NULL,
	AreaDisciplinare VARCHAR(30) NOT NULL,
	AbilitaRichieste TEXT NULL,
	DataPubblicazione DATE NOT NULL,
	DataScadenza DATE,
	MaxIscrizioni INT(6),
	Azienda INT(6) NOT NULL,
	Indirizzo INT(6) NOT NULL,

	PRIMARY KEY(IdAnnuncio),
	FOREIGN KEY(Azienda) REFERENCES Aziende(IdUtente),
	FOREIGN KEY(Indirizzo) REFERENCES Indirizzi(IdIndirizzo)
);
CREATE TABLE Candidarsi(
	IdStudente INT(6) NOT NULL,
	IdAnnuncio INT(6) NOT NULL,
	Legale BIT NOT NULL,
	
	PRIMARY KEY(IdStudente, IdAnnuncio),
	FOREIGN KEY (IdStudente) REFERENCES Studenti(IdUtente),
	FOREIGN KEY (IdAnnuncio) REFERENCES Annunci(IdAnnuncio)
);

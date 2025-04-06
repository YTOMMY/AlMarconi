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
	2FA BIT NOT NULL DEFAULT 0,
	Verificato BIT NOT NULL DEFAULT 0,
	DataCreazione DATE NOT NULL DEFAULT CURDATE(),

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
	Citta INT(5) NOT NULL,

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
	Residenza INT(7) NOT NULL,
	Domicilio INT(7) NULL,
	
	PRIMARY KEY(IdUtente),
	FOREIGN KEY(IdUtente) REFERENCES Utenti(IdUtente),
	FOREIGN KEY(Residenza) REFERENCES Indirizzi(IdIndirizzo),
	FOREIGN KEY(Domicilio) REFERENCES Indirizzi(IdIndirizzo)
);
CREATE TABLE Abilita(
	IdAbilita INT(7) AUTO_INCREMENT NOT NULL,
	Descrizione TEXT NOT NULL,
	Studente INT(6) NOT NULL,

	PRIMARY KEY(IdAbilita),
	FOREIGN KEY(Studente) REFERENCES Studenti(IdUtente)
);
CREATE TABLE Referenti(
	CodiceFiscale VARCHAR(16) NOT NULL UNIQUE,
	Nome VARCHAR(50) NOT NULL,
	Cognome VARCHAR(50) NOT NULL,
	DataNascita DATE NOT NULL,
	LuogoNascita INT(5) NOT NULL,
	Ruolo VARCHAR(30) NOT NULL,	

	PRIMARY KEY(CodiceFiscale),	
	FOREIGN KEY(LuogoNascita) REFERENCES Citta(IdCitta)	
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
CREATE TABLE Sedi(
	IdSede INT(6) NOT NULL AUTO_INCREMENT,
	Azienda INT(6) NOT NULL,
	Indirizzo INT(7) NOT NULL,
	Legale BIT(1) NOT NULL,
	
	PRIMARY KEY(IdSede),
	FOREIGN KEY(Azienda) REFERENCES Aziende(IdUtente),
	FOREIGN KEY(Indirizzo) REFERENCES Indirizzi(IdIndirizzi)
);
CREATE TABLE Annunci(
	IdAnnuncio INT(6) AUTO_INCREMENT NOT NULL,
	TipoContratto VARCHAR(50) NOT NULL,
	Mansione VARCHAR(30) NOT NULL,
	Descrizione TEXT NOT NULL,
	AreaDisciplinare VARCHAR(30) NOT NULL,
	AbilitaRichieste TEXT NULL,
	DataPubblicazione DATE NOT NULL DEFAULT CURDATE(),
	DataScadenza DATE NULL,
	MaxIscrizioni INT(6) NULL,
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

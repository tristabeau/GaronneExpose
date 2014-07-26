CREATE TABLE groupe (
	idgroupe          INT AUTO_INCREMENT NOT NULL,
	nom               VARCHAR(50) NOT NULL,
	PRIMARY KEY (idgroupe))
ENGINE = MYISAM CHARACTER SET UTF8;

CREATE TABLE categorie (
	idcategorie       INT AUTO_INCREMENT NOT NULL,
	nom               VARCHAR(50) NOT NULL,
	tag               VARCHAR(5) NOT NULL,
	pere_idcategorie  INT,
	PRIMARY KEY (idcategorie),
	FOREIGN KEY (pere_idcategorie) REFERENCES categorie (idcategorie))
ENGINE = MYISAM CHARACTER SET UTF8;

CREATE TABLE membre (
	idmembre          INT AUTO_INCREMENT NOT NULL,
	pseudo            VARCHAR(50) NOT NULL,
	mdp               VARCHAR(32) NOT NULL,
	age               TINYINT NOT NULL,
	descr             VARCHAR(250) NOT NULL,
	facebook          VARCHAR(50) NOT NULL,
	twitter           VARCHAR(50) NOT NULL,
	google            VARCHAR(50) NOT NULL,
	site              VARCHAR(150) NOT NULL,
	image             VARCHAR(250) NOT NULL,
	salt              VARCHAR(5) NOT NULL,
	mail              VARCHAR(150) NOT NULL,
	active            TINYINT(1) DEFAULT FALSE NOT NULL,
	activation        VARCHAR(20) NOT NULL,
	titre             VARCHAR(100) NOT NULL,
	fk_idgroupe       INT NOT NULL,
	PRIMARY KEY (idmembre),
	FOREIGN KEY (fk_idgroupe) REFERENCES groupe (idgroupe))
ENGINE = MYISAM CHARACTER SET UTF8;

CREATE TABLE article (
	idarticle         INT AUTO_INCREMENT NOT NULL,
	titre             VARCHAR(150) NOT NULL,
	date              VARCHAR(10) NOT NULL,
	annee             VARCHAR(4) NOT NULL,
	mois              VARCHAR(2) NOT NULL,
	jour              VARCHAR(2) NOT NULL,
	heure             VARCHAR(5) NOT NULL,
	contenu           TEXT NOT NULL,
	image             VARCHAR(250) NOT NULL,
	nb_vues           TINYINT NOT NULL,
	vedette           TINYINT(1) DEFAULT FALSE NOT NULL,
	publie            TINYINT(1) DEFAULT FALSE NOT NULL,
	permalien         VARCHAR(200) NOT NULL,
	fk_idmembre       INT NOT NULL,
	fk_idcategorie    INT NOT NULL,
	PRIMARY KEY (idarticle),
	FOREIGN KEY (fk_idmembre) REFERENCES membre (idmembre),
	FOREIGN KEY (fk_idcategorie) REFERENCES categorie (idcategorie))
ENGINE = MYISAM CHARACTER SET UTF8;

CREATE TABLE commentaire (
	idcommentaire     INT AUTO_INCREMENT NOT NULL,
	date              VARCHAR(10) NOT NULL,
	contenu           VARCHAR(250) NOT NULL,
	fk_idmembre       INT NOT NULL,
	fk_idarticle      INT NOT NULL,
	PRIMARY KEY (idcommentaire),
	FOREIGN KEY (fk_idmembre) REFERENCES membre (idmembre),
	FOREIGN KEY (fk_idarticle) REFERENCES article (idarticle))
ENGINE = MYISAM CHARACTER SET UTF8;


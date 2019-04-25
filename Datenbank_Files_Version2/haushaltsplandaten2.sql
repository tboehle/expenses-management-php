CREATE OR REPLACE SCHEMA haushaltsdaten2;
/*Erstellen der Tabelle Kategorie*/



CREATE OR REPLACE TABLE haushaltsdaten2.kategorie (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name MEDIUMTEXT NULL,
  eingang TINYINT not null,
  PRIMARY KEY (`id`)
);


INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Lebensmittel', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Lebensmittel', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Hobbies', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Fahrtkosten', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Bueromaterial', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Miete', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Ausgehen', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Kleidung', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Versicherungen', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Geschenke', 1);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Multimedia', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Sonstige', 0);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Gehalt', 1);
INSERT INTO haushaltsdaten2.kategorie (name, eingang) VALUES ('Geldanlagen', 1);

/*Erstellen der Tabelle Konto*/

CREATE OR REPLACE TABLE haushaltsdaten2.konto (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  kontostand DECIMAL(20,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);


/*Erstellen der Tabelle Users*/

CREATE OR REPLACE TABLE `haushaltsdaten2`.`users`
(
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
     `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `hash` VARCHAR(32) NOT NULL,
    `active` BOOL NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
);

/*Erstellen der Tabelle Transaktion*/

CREATE OR REPLACE TABLE haushaltsdaten2.transaktion (
  id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  zahlungsart VARCHAR(10) NOT NULL,
  datum DATE NOT NULL,
  kategorie INT(11) NOT NULL,
  betrag DECIMAL(15,2) NOT NULL,
  user BIGINT(20),
  PRIMARY KEY (id),
  INDEX kategorie_transaktion (kategorie),
  INDEX users_transaktion (user),
  CONSTRAINT kategorie_transaktion FOREIGN KEY (kategorie) REFERENCES kategorie (id)
  );

/* Fremdschlüssel auf Users hinzufügen*/
 ALTER TABLE `transaktion` ADD CONSTRAINT `users_transaktion` FOREIGN KEY (`user`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*Testdaten*/

INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-21', 5, 4.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-20', 3, 6.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-16', 2, 60.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Einzahlung', '2017-04-23', 3, 30.00,1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-22', 3, 3.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-20', 8, 50.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Einzahlung', '2017-04-10', 3, 4.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-11', 4, 7.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-20', 3, 10.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-15', 7, 10.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Einzahlung', '2017-04-20', 14, 6.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-13', 4, 3.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Einzahlung', '2017-02-03', 13, 800.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-05-01', 6, 380.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-03-02', 5, 10.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2016-12-14', 7, 30.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-05-02', 7, 20.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-26', 9, 50.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Auszahlung', '2017-04-29', 11, 300.00, 1);
INSERT INTO haushaltsdaten2.transaktion (zahlungsart, datum, kategorie, betrag, user) VALUES ('Einzahlung', '2017-04-02', 13, 800.00, 1);
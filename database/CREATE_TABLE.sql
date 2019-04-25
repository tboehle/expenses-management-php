
/* create schema plandaten */
CREATE TABLE kategorie (
id INT(11) NOT NULL,
name MEDIUMTEXT NULL,
PRIMARY KEY (`id`)
);



CREATE TABLE `konto` (
id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
kontostand DECIMAL(20,2) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
);



CREATE TABLE `transaktion` (
id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
art INT(11) NOT NULL,
datum DATE NOT NULL,
kategorie INT(11) NOT NULL,
betrag DECIMAL(15,2) NOT NULL,
konto BIGINT(20) UNSIGNED NOT NULL,
PRIMARY KEY (id),
INDEX kat (kategorie),
INDEX konto (konto),
CONSTRAINT kat FOREIGN KEY (kategorie) REFERENCES kategorie (id),
CONSTRAINT konto FOREIGN KEY (konto) REFERENCES konto (id)
);


INSERT INTO kategorie (id, name) VALUES (0, 'Lebensmittel');
INSERT INTO kategorie (id, name) VALUES (1, 'Hobbies');
INSERT INTO kategorie (id, name) VALUES (2, 'Fahrtkosten');
INSERT INTO kategorie (id, name) VALUES (3, 'Büromaterial');
INSERT INTO kategorie (id, name) VALUES (4, 'Miete');
INSERT INTO kategorie (id, name) VALUES (5, 'Ausgehen');
INSERT INTO kategorie (id, name) VALUES (6, 'Kleidung');
INSERT INTO kategorie (id, name) VALUES (7, 'Versicherungen');
INSERT INTO kategorie (id, name) VALUES (8, 'Geschenke');
INSERT INTO kategorie (id, name) VALUES (9, 'Multimedia');
INSERT INTO kategorie (id, name) VALUES (10, 'Sonstige');

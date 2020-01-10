DROP DATABASE IF EXISTS car_rental;
CREATE DATABASE car_rental;
USE car_rental;

CREATE TABLE `Customers` (
  `Personal number` VARCHAR(10),
  `Full name` VARCHAR(100) NOT NULL,
  `Address` VARCHAR(256) NOT NULL,
  `Postal address` VARCHAR(256) NOT NULL,
  `Phone number` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`Personal Number`));

CREATE TABLE Cars (
  `Registration` VARCHAR(6) NOT NULL,
  `Make` VARCHAR(20) NOT NULL,
  `Color` VARCHAR(20) NOT NULL,
  `Year` INTEGER(4) UNSIGNED NOT NULL,
  `Price` FLOAT UNSIGNED NOT NULL,
  `Rented by` VARCHAR(10) DEFAULT "Free",
  `Rented from` DATETIME DEFAULT NULL,
  PRIMARY KEY(`Registration`);

CREATE TABLE `Allowed Colors` (
`Colors` VARCHAR(20) NOT NULL KEY);

CREATE TABLE `Allowed Makers` (
  `Makers` VARCHAR(20) NOT NULL KEY);
  
CREATE TABLE `History` (
  `Registration` VARCHAR(6) NOT NULL,
  `Personal number` VARCHAR(10),
  `Rented from` DATETIME DEFAULT NULL,
  `Rented until` DATETIME DEFAULT NULL,
  FOREIGN KEY (`Registration`) REFERENCES Cars(`Registration`),
  FOREIGN KEY (`Personal number`) REFERENCES Customers(`Personal number`));
  
INSERT INTO Customers (
`Personal number`, `Full name`, `Address`, `Postal address`, `Phone number`)
  VALUES(
    4811270481, "Darwin Eichart", "Valhallavägen 13", "Stockholm 11456", "0714155671");

INSERT INTO Customers (
  `Personal number`, `Full name`, `Address`, `Postal address`, `Phone number`)
  VALUES
  (8001112013, "Darwin Eichart", "Nygatan 13", "11712 Stockholm", "0714155671"),
  (5611291047, "Hamburger Man", "Backeby 45", "11824 Stockholm", "0788451112"),
  (1802222685, "Bob Dylan", "Hornsgatan 12", "11725 Stockholm", "0786612451"),
  (2403131556, "Dr.Alban", "Vasagatan 113A", "11842 Stockholm", "0707441144"),
  (8205030789, "Michael Jackson", "Hornsgatan 12", "11725 Stockholm", "0845127712"),
  (1412148197, "Da Baby", "Västra svärdlångsvägen 12", "11725 Stockholm", "0739912451");

INSERT INTO Cars (
  `Registration`, `Make`, `Color`, `Year`, `Price`)
  VALUES
  ("ABC123", "Toyota", "Gold", 1990, 200),
  ("GAD931", "Volvo", "White", 1989, 100),
  ("BBB123", "Peugot", "Silver", 1995, 150),
  ("GAF413", "Nissan", "Green", 1993, 100),
  ("NDA911", "General Motors", "Blue", 2014, 250),
  ("SEC555", "Tesla", "Black", 2018, 250);

INSERT INTO `Allowed Colors` (Colors)
VALUES
("Black"), ("White"), ("Blue"), ("Red"), ("Green"), ("Gold"), ("Silver");

INSERT INTO `Allowed Makers` (Makers)
VALUES
("Toyota"), ("Volvo"), ("Peugot"), ("Nissan"), ("General Motors"), ("Tesla");







ALTER TABLE Cars MODIFY 
COLUMN `Rented from` VARCHAR(50) NOT NULL DEFAULT "Free";

ALTER TABLE Cars MODIFY 
COLUMN `Rented by` VARCHAR(50) NOT NULL DEFAULT "";

ALTER TABLE Cars MODIFY 
COLUMN `Personal number` INT;

ALTER TABLE Cars DROP 
COLUMN `Rented from`;

ALTER TABLE Cars DROP FOREIGN KEY Cars_ibfk_2;

SELECT `Registration`, `Color`, `Make` FROM Cars WHERE
    (History.`Rented from` IS NULL OR History.`Rented from` = `Free`);

ALTER TABLE Cars ADD `Rented from` VARCHAR(50);
ALTER TABLE Cars ADD FOREIGN KEY (`Rented from`) REFERENCES `History`(`Rented from`);


INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Filip Gustavsson';
INSERT INTO Events(accountNumber, amount) SELECT accountNumber, -300 FROM Accounts WHERE accountNumber = 3;
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';

SELECT * FROM Cars WHERE `Registration` = "ABC123"

INSERT INTO History (`Personal number`, `Registration`, `Cost`,
  `Rented from`, `Rented until`, `Days`)
  VALUES()

  SELECT * FROM Cars WHERE `Registration` = "ABC123"

INSERT INTO History (`Personal number`, `Registration`,
`Rented from`)
SELECT `Rented by`, Registration, `Rented from`
FROM Cars WHERE `Registration` = 'ABC123';

UPDATE History SET 
History.`Personal number` = `Rented by`,
History.`Registration` = `Registration`,
History.`Rented from` = `Rented from`,
History.`Rented until` = NOW()
FROM History INNER JOIN Cars
WHERE `Registration` = "ABC123";

SELECT History SET 
History.`Personal number` = `Rented by`,
History.`Registration` = `Registration`,
History.`Rented from` = `Rented from`,
History.`Rented until` = NOW()
FROM History INNER JOIN Cars
WHERE `Registration` = "ABC123";

ALTER TABLE History
ADD `Rented until` DATETIME DEFAULT NOW();

UPDATE Cars SET 
`Rented by` ='Free', 
`Rented from`= NULL
WHERE `Registration` = 'ABC123';

INSERT INTO History (`Personal number`, `Registration`, `Rented from`,
`Rented until`)
VALUES (7612300144, "ABC123", "2019-12-18 12:53:24", 
"2019-12-27 08:04:01");

DELETE FROM History WHERE `Personal number` = 7612300144;
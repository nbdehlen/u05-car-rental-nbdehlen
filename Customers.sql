DROP DATABASE IF EXISTS car_rental;
CREATE DATABASE car_rental;
USE car_rental;

CREATE TABLE `Customers` (
  `Personal number` BIGINT NOT NULL,
  `Full name` VARCHAR(100) NOT NULL,
  `Address` VARCHAR(256) NOT NULL,
  `Postal address` VARCHAR(256) NOT NULL,
  `Phone number` INTEGER NOT NULL,
  PRIMARY KEY (`Personal Number`));

CREATE TABLE Cars (
  `Registration` VARCHAR(6) NOT NULL,
  `Make` VARCHAR(20) NOT NULL,
  `Color` VARCHAR(20) NOT NULL,
  `Year` INTEGER(4) UNSIGNED NOT NULL,
  `Price` INTEGER UNSIGNED NOT NULL,
  `Rented by` VARCHAR(50) NOT NULL,
  PRIMARY KEY(`Registration`),
  `Personal number` BIGINT NOT NULL,
  FOREIGN KEY (`Personal number`) REFERENCES Customers(`Personal number`));

ALTER TABLE Cars (
`Rented from` VARCHAR(50) NOT NULL DEFAULT "Free",
FOREIGN KEY (`Rented from`) REFERENCES History(`Rented from`));

CREATE TABLE `Allowed Colors` (
`Colors` VARCHAR(20) NOT NULL KEY);

CREATE TABLE `Allowed Makers` (
  `Makers` VARCHAR(20) NOT NULL KEY);

CREATE TABLE `History` (
  `Registration` VARCHAR(6) NOT NULL,
  `Personal number` BIGINT NOT NULL,
  `Rented from` VARCHAR(50) NOT NULL DEFAULT "Free",
  `Rented until` VARCHAR(50) NOT NULL,
  `Cost` INTEGER NOT NULL,
  PRIMARY KEY (`Rented from`),
  FOREIGN KEY (`Registration`) REFERENCES Cars(`Registration`),
  FOREIGN KEY (`Personal number`) REFERENCES Customers(`Personal number`));
  
ALTER TABLE Cars ADD `Rented from` VARCHAR(50) NOT NULL DEFAULT "Free";
ALTER TABLE Cars ADD FOREIGN KEY (`Rented from`) REFERENCES `History`(`Rented from`);


INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Filip Gustavsson';
INSERT INTO Events(accountNumber, amount) SELECT accountNumber, -300 FROM Accounts WHERE accountNumber = 3;
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';


INSERT INTO Customers (
`Personal number`, `Full name`, `Address`, `Postal address`, `Phone number`)
  VALUES(
    4811270481, "Darwin Eichart", "Valhallavägen 13", "Stockholm 11456", "0714155671");

INSERT INTO Customers (
  `Personal number`, `Full name`, `Address`, `Postal address`, `Phone number`)
  VALUES
  (4811270481, "Darwin Eichart", "Nygatan 13", "11712 Stockholm", "0714155671"),
  (7612300144, "Hamburger Man", "Backeby 45", "11824 Stockholm", "0788451112"),
  (9804019172, "Bob Dylan", "Hornsgatan 12", "11725 Stockholm", "0786612451"),
  (6401126132, "Dr.Alban", "Vasagatan 113A", "11842 Stockholm", "0707441144"),
  (9108091142, "Michael Jackson", "Hornsgatan 12", "11725 Stockholm", "0845127712"),
  (8411081178, "Da Baby", "Västra svärdlångsvägen 12", "11725 Stockholm", "0739912451");

INSERT INTO Cars (
  `Registration`, `Make`, `Color`, `Year`, `Price`)
  VALUES(
  "ABC123", "Toyota", "Gold", 1990, 200);

INSERT INTO Cars (
  `Registration`, `Make`, `Color`, `Year`, `Price`)
  VALUES(
  "GAD931", "Volvo", "White", 1989, 100);

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

ALTER TABLE Customers MODIFY COLUMN `Personal number` BIGINT;
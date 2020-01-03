DROP DATABASE IF EXISTS car_rental;
CREATE DATABASE car_rental;
USE car_rental;

CREATE TABLE `Customers` (
  `Personal number` INTEGER NOT NULL,
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
  `Rented from` VARCHAR(50) NOT NULL,
  PRIMARY KEY(`Registration`),
  `Personal number` INTEGER NOT NULL,
  FOREIGN KEY (`Personal number`) REFERENCES Customers(`Personal number`)
  FOREIGN KEY (`Rented from`) REFERENCES History(`Rented from`));

CREATE TABLE `Allowed Colors` (
`Colors` VARCHAR(20) NOT NULL KEY);

CREATE TABLE `Allowed Makers` (
  `Makers` VARCHAR(20) NOT NULL KEY);

CREATE TABLE `History` (
  `Registration` VARCHAR(6) NOT NULL,
  `Personal number` INTEGER NOT NULL,
  `Rented from` VARCHAR(50) NOT NULL,
  `Rented until` VARCHAR(50) NOT NULL,
  `Cost` INTEGER NOT NULL,
  PRIMARY KEY (`Rented from`),
  FOREIGN KEY (`Registration`) REFERENCES Cars(`Registration`),
  FOREIGN KEY (`Personal number`) REFERENCES Customers(`Personal number`));
  
ALTER TABLE Cars ADD `Rented from` VARCHAR(50) NOT NULL DEFAULT "Free";
ALTER TABLE Cars ADD FOREIGN KEY (`Rented from`) REFERENCES `History`(`Rented from`);

INSERT INTO Customers(customerName)
  VALUES ('Adam Bertilsson'), ('Bertil Ceasarsson'),  ('Ceasar Davidsson'),
         ('David Eriksson'), ('Erik Filipsson'),  ('Filip Gustavsson');

INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'David Eriksson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'David Eriksson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Erik Filipsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Filip Gustavsson';

INSERT INTO Events(accountNumber, amount) SELECT accountNumber, 100 FROM Accounts;
INSERT INTO Events(accountNumber, amount) SELECT accountNumber, -200 FROM Accounts WHERE accountNumber = 1;
INSERT INTO Events(accountNumber, amount) SELECT accountNumber, 200 FROM Accounts WHERE accountNumber = 2;
INSERT INTO Events(accountNumber, amount) SELECT accountNumber, -300 FROM Accounts WHERE accountNumber = 3;

INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Adam Bertilsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Bertil Ceasarsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'David Eriksson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Ceasar Davidsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'David Eriksson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Erik Filipsson';
INSERT INTO Accounts(customerNumber) SELECT customerNumber FROM Customers WHERE customerName = 'Filip Gustavsson';

select * from Customers;
select * from Accounts;
select * from Events;

INSERT INTO Customers (
  `Personal number`, `Full name`, `Address`, `Postal Address`, `Phone number`)
  VALUES(
    1111270418, "Darwin Eichart", "Valhallavägen 13", "Stockholm 11456", "0714155671");

INSERT INTO Customers (
  `Personal number`, `Full name`, `Address`, `Postal Address`, `Phone number`)
  VALUES(
  1011272222, "Hamburger Man", "Backeby 45", "Stockholm 11725", "0788451112");

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

Change "Rented by to a default of free", can possibly change to date format?
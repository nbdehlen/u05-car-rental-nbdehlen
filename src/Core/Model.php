<?php
  namespace Main\Core;
  use PDOException;

  class Model extends Config {

    //Get users and list of which are currently renting
      protected function getAllUsers() {

        $sql = "SELECT Customers.`Personal number`, `Full name`, `Address`, `Postal address`,
        `Phone number`,
         `Rented by` AS Cars
         FROM Customers INNER JOIN Cars ON 
         Customers.`Personal number` = Cars.`Rented by`
         UNION
         SELECT Customers.`Personal number`, `Full name`, `Address`, `Postal address`,
        `Phone number`,
        `Rented by` AS Cars
        FROM Customers LEFT JOIN Cars ON
        Customers.`Personal number` = Cars.`Rented by`";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        }


      //Add new user 
    protected function setUser($PersonNumber, $Name, $Address, 
    $PostalAddress, $PhoneNumber) {
        $sql = "INSERT INTO Customers (`Personal number`, `Full name`, Address, 
        `Postal address`, `Phone number`)
        VALUES (?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$PersonNumber, $Name, $Address, $PostalAddress, 
        $PhoneNumber]);
    }

    //Get list of cars
    protected function getCars() {
      $sql = "SELECT * FROM Cars";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    //Add new car details
    protected function setCar($Registration, $Make, $Color, 
    $Year, $Price) {
        $sql = "INSERT INTO Cars (`Registration`, `Make`, Color, 
        `Year`, `Price`)
        VALUES (?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$Registration, $Make, $Color, $Year, 
        $Price]);
    }

   //Get list of allowed car colors
    protected function getColors(){
      $sql = "SELECT * FROM `Allowed Colors`";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    //Get list of allowed car makers
    protected function getMakers(){
      $sql = "SELECT * FROM `Allowed Makers`";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

  //Get list of cars currently not being rented
  protected function getRegFree() {
    $sql = "SELECT `Registration`, `Color`, `Make` FROM Cars WHERE
    `Rented by` = 'Free'";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

//Get personal number for dropdown check out cars
protected function getPr() {
  $sql = "SELECT `Personal number` FROM Customers";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll();
}

// Set time of checkout and personal number for person renting it
protected function setCheckOutTime($rentedBy, $reg) {
    $sql = "UPDATE Cars SET 
    `Rented by` = ?, 
    `Rented from` = NOW() WHERE `Registration` = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$rentedBy, $reg]);
}

//Get cars currently rented out
protected function getRegRented() {
  $sql = "SELECT `Registration`, `Color`, `Make` FROM Cars WHERE
  `Rented by` != 'Free'";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll();
}

//Set Car to edit
protected function setCarEdit($make, $color, $year, $price, $reg) {
    $sql = "UPDATE Cars SET
    `Make` = ?, `Color` = ?, `Year` = ?, `Price` = ?
    WHERE `Registration` = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$make, $color, $year, $price, $reg]);
}

//Set car remove
protected function setCarRemove($reg) {
  $sql = "DELETE FROM History WHERE 
  Registration = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$reg]);

  $sql2 = "DELETE FROM Cars WHERE 
  Registration = ?";
  $stmt2 = $this->connect()->prepare($sql2);
  $stmt2->execute([$reg]);
}

  //Set history for cars rented
  protected function setRegReturned($reg){
    try {
      $sql = "INSERT INTO History (`Registration`, `Personal number`,
      `Rented from`)
      SELECT Registration, `Rented by`, `Rented from`
      FROM Cars WHERE `Registration` = ?";

      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$reg]);

      $sql2 = "UPDATE Cars SET 
      `Rented by` ='Free', 
      `Rented from`= NULL
      WHERE `Registration` = ?";

      $stmt2 = $this->connect()->prepare($sql2);
      $stmt2->execute([$reg]);

    } catch (PDOException $e) {
      echo "Error : " . $e->getMessage();
    }
  }
  //get history
  /*protected function getHistory() {
      $sql = "SELECT * FROM History";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
  }*/

protected function getConvertions() {
  $sql = "SELECT History.`Registration`, History.`Personal number`,
  History.`Rented from`, History.`Rented until`,
  Price AS Price FROM History INNER JOIN Cars ON
   History.`Registration` = Cars.`Registration` 
   UNION SELECT History.`Registration`, History.`Personal number`,
   History.`Rented from`, History.`Rented until`,
   Price AS Price
    FROM History LEFT JOIN Cars ON
  History.`Registration` = Cars.`Registration`";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  $historyPrice = $stmt->fetchAll();
  var_dump($historyPrice);
  for ($i=0; $i< count($historyPrice); $i++) {
    $interval = strtotime($historyPrice[$i]['Rented until']) 
    - strtotime($historyPrice[$i]['Rented from']);

    //$days[] = ceil($interval/86400);
    $historyPrice[$i]['Days'] = ceil($interval/86400);
    $historyPrice[$i]['Cost'] = $historyPrice[$i]['Price'] * $historyPrice[$i]['Days'];

    //$reg[] = $historyPrice[$i]['Registration'];
    }
    //var_dump($days);
    //var_dump($cost);
    //var_dump($historyPrice);
    return ($historyPrice);
}


  //convert dates into days and total cost for displaying history
 /* protected function getConvertions() {
    $sqlDates = "SELECT `Rented from`,`Rented until`, `Registration` FROM History";
    $stmt = $this->connect()->prepare($sqlDates);
    $stmt->execute();
    $dates = $stmt->fetchAll();

    $sqlPrice = "SELECT `Price` FROM Cars 
      RIGHT JOIN History ON
      Cars.Registration = History.Registration";
      $stmt2 = $this->connect()->prepare($sqlPrice);
      $stmt2->execute();
      $prices = $stmt2->fetchAll();

    for ($i=0; $i< count($dates); $i++) {
      $interval = strtotime($dates[$i]['Rented until']) 
      - strtotime($dates[$i]['Rented from']);

      $days[] = ceil($interval/86400);

      $cost[] = $prices[$i]['Price'] * $days[$i];

      $reg[] = $dates[$i]['Registration'];
      }
      return array($days, $cost, $reg);
  }
*/

  //Set user to edit
protected function setUserEdit($name, $address, $phone, $postal, $pn) {
  $sql = "UPDATE Customers SET
  `Full name` = ?,
  `Address` = ?,
  `Phone number` = ?,
  `Postal address` = ?
  WHERE `Personal number` = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$name, $address, $phone, $postal, $pn]);
}

//Set user remove
protected function setUserRemove($pn) {
  $sql2 = "DELETE FROM History WHERE `Personal number` = ?";
  $stmt2 = $this->connect()->prepare($sql2);
  $stmt2->execute([$pn]);

  $sql = "DELETE FROM Customers WHERE `Personal number` = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$pn]);
}
}
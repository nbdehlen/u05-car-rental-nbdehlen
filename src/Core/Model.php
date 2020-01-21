<?php
  namespace Main\Core;

  class Model extends Config {

    /* Get all users and Cars column to disable customers 
    from being edited/deleted if renting */
      protected function getAllUsers() {

        $sql = "SELECT Customers.*,
         `Rented by` AS Cars
         FROM Customers INNER JOIN Cars ON 
         Customers.`Personal number` = Cars.`Rented by`
         UNION
         SELECT Customers.*,
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
  }


/* Get History, days rented and total costs */
protected function getConvertions() {
  $sql = "SELECT History.*,
  Price AS Price FROM History INNER JOIN Cars ON
   (History.`Registration` = Cars.`Registration`
   AND History.`Rented from` != History.`Rented until`)";

  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  $historyPrice = $stmt->fetchAll();
  
  /* Convert dates into days rounded up and total cost for each
  check-out - check-in */
  for ($i=0; $i< count($historyPrice); $i++) {
    $interval = strtotime($historyPrice[$i]['Rented until']) 
    - strtotime($historyPrice[$i]['Rented from']);

    $historyPrice[$i]['Days'] = ceil($interval/86400);
    $historyPrice[$i]['Cost'] = $historyPrice[$i]['Price'] * $historyPrice[$i]['Days'];
  }
    return ($historyPrice);
}

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
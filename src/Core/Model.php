<?php
  namespace Main\Core;
  
  class Model extends Config {

      public function getAll() {
        $sql = "SELECT * FROM Customers";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }


      /*
      public function getIndex($index) {
        if ($index < count($this->personArray)) {
          return $this->personArray[$index];
        }
        else {
          return null;
        }
      }
      
      public function getInterval($startIndex, $lastIndex) {
        if (($startIndex >= 0) && ($lastIndex < count($this->personArray))) {
          return $this->personArray;
        }
        else {
          return null;
        }
      }
*/
      /*public function getInterval($startIndex, $lastIndex) {
        if (($startIndex >= 0) && ($lastIndex < count($this->personArray))) {
          $result = [];

          for ($index = $startIndex; $index <= $lastIndex; ++$index) {
             $result[] = $this->personArray[$index];
          }

          return $result;
        }
        else {
          return null;
        }
      }*/

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
    //Prepared statement
    $sql = "SELECT `Registration`, `Color`, `Make` FROM Cars WHERE
    `Rented by` = 'Free'";
    //$sql = [$sql1, $sql2];
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    //var_dump($sql);
    return $stmt->fetchAll();
}

//Get personal number for dropdown check out cars
protected function getPr() {
  $sql = "SELECT `Personal number` FROM Customers";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  //var_dump($sql);
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
  //$sql = [$sql1, $sql2];
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute();
  //var_dump($sql);
  return $stmt->fetchAll();
}

//Set history for cars rented
protected function setRegReturned($reg) {
  $sql = "INSERT INTO History (`Personal number`, `Registration`, `Cost`,
  `Rented from`, `Rented until`, `Days`)
  VALUES (?,?,?,?,?,?)";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$pr, $reg, $rentedFrom,
  $rentedUntil]);

}

/*
actualFunction:
            get $reg from function
SQLcalcs based on row matching $reg actualFunction :
        get "person number" from Cars(rented by)
        get "rented from" from Cars(registration matching $reg)
        Update Cars based on matching $reg
ownFunction:  
            Calculate days here
            Calculate cost here (price*days)
ownSQL:
          Update "Rented until" with NOW();
*/


/*

 public function transfer($fromAccountNumber) {
    $customersQuery = <<< __HTML
       SELECT CONCAT(customer.customerNumber, ',',
       customer.customerName, ',', account.accountNumber)
       FROM Customers customer JOIN Accounts account
       ON ((customer.customerNumber = account.customerNumber)
       AND (accountNumber != :fromAccountNumber));
__HTML;

*/
  }
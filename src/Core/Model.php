<?php
  namespace Main\Core;
  use PDOException;
  use DateTime;

  class Model extends Config {

    //Join `rented by` where Cars.`Personal number` =
      protected function getAllUsers() {
       /* $sql = "SELECT * FROM Customers";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $allCustomers = $stmt->fetchAll();
        //return $stmt->fetchAll();
        $allDisabled = $this->disableUserRemove();*/
      

       /* for ($i = 0; $i < count($allCustomers); $i++) {
          if ($allCustomers[$i]['Personal number'] == ) {
            $boolArr[] = true; 
          }*/

        /*$sql = "SELECT * FROM Cars
        LEFT JOIN Customers ON Customers.`Personal number` = Cars.`Rented by`
        UNION ALL
        SELECT * FROM Cars
        RIGHT JOIN Customers ON Cars.`Rented by` = Customers.`Personal number`";*/
        /*WHERE NOT EXISTS (SELECT 1 FROM Customers I)";*/

        /*$sql = "SELECT * FROM Customers
        LEFT JOIN Cars ON Customers.`Personal number` = Cars.`Rented by`
        ";*/

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
        Customers.`Personal number` = Cars.`Rented by`
         ";


        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        //$allDisabled = $this->disableUserRemove();
        }

      /*protected function disableUserRemove() {
        $sql = "SELECT `Rented by` FROM Cars";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }*/

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

//Set Car to edit
protected function setCarEdit($make, $color, $year, $price, $reg) {
    $sql = "UPDATE Cars SET
    `Make` = ?,
    `Color` = ?,
    `Year` = ?,
    `Price` = ?
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
  protected function setRegReturned($reg)
{
    try {
      /*$sql = "INSERT INTO History (`Personal number`, `Registration`, `Cost`,
  `Rented from`, `Rented until`, `Days`)
  VALUES (?,?,?,?,?,?)";*/
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
/*
actualFunction:
            get $reg from function XXX
SQLcalcs based on row matching $reg actualFunction :
       XXXX get "person number" from Cars(rented by)XXXX
       XXX get "rented from" from Cars(registration matching $reg) XXX
        XXX Update Cars based on matching $reg XXXX
ownFunction:  
            Calculate days here
            Calculate cost here (price*days)
ownSQL:
           XXXUpdate "Rented until" with NOW(); XXX
*/

/*
$abg = <<< SQL
  SELECT * FROM Cars WHERE `Registration` = $reg
  INSERT INTO History (`Personal number`, `Registration`, `Cost`,
  `Rented from`, `Rented until`, `Days`)
  VALUES()
SQL;
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
  protected function getHistory() {
      $sql = "SELECT * FROM History";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
  }


  //convert dates into days and total cost for displaying history
  protected function getConvertions() {
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
      //echo $prices[$i]['Price'] . "  \n  ";
      $reg[] = $dates[$i]['Registration'];
      }
      return array($days, $cost, $reg);
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

/*

  -....................
  
} else if 

*/
  /*
SQL: Count number of rows in history,
SQL: Get Reg and Price from Cars table
SQL: Get Days from History table
for each row:
        get days in an array,
        get cost in an array
End for each

Sum of all cost
  */
<?php
  namespace Main\Core;
  
  class Model extends Config {
      //private $personArray;
      /*
      public function __construct() {
        $adam = ["name" => "Adam Bertilsson", "address" => "Åvägen 1", "phone" => "12345"];
        $bertil = ["name" => "Bertil Ceasarsson", "address" => "Åvägen 2", "phone" => "23456"];
        $ceasar = ["name" => "Ceasar Davidsson", "address" => "Åvägen 3", "phone" => "34567"];
        $this->personArray = [$adam, $bertil, $ceasar];
      }
      */

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

      protected function getUser($name) {
        //Prepared statement
        $sql = "SELECT * FROM Customers WHERE Name = ?";
        $stmt = $this->connect()->prepare($sql);
        //execute only takes an array so we put one in there, thats all.
        $stmt->execute([$name]);

        $results = $stmt->fetchAll();
        return $results;
    }
//$PersonNumber, $Name, $Address, $PostalAddress, $PhoneNumber
    protected function setUser($PersonNumber, $Name, $Address, $PostalAddress, $PhoneNumber) {
        //Prepared statement
        $sql = "INSERT INTO Customers (`Personal number`, `Full name`, Address, 
        `Postal address`, `Phone number`)
        VALUES (?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        //execute only takes an array so we put one in there, thats all.
        $stmt->execute([$PersonNumber, $Name, $Address, $PostalAddress, 
        $PhoneNumber]);
    }

    protected function getCars() {
      $sql = "SELECT * FROM Cars";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }



  }
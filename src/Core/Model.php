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

      protected function getUser($name) {
        //Prepared statement
        $sql = "SELECT * FROM Customers WHERE Name = ?";
        $stmt = $this->connect()->prepare($sql);
        //execute only takes an array so we put one in there, thats all.
        $stmt->execute([$name]);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setUser($PersonNumber, $Name, $Address, 
    $PostalAddress, $PhoneNumber) {
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

    protected function setCar($Registration, $Make, $Color, 
    $Year, $Price) {
        //Prepared statement
        $sql = "INSERT INTO Cars (`Registration`, `Make`, Color, 
        `Year`, `Price`)
        VALUES (?,?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        //execute only takes an array so we put one in there, thats all.
        $stmt->execute([$Registration, $Make, $Color, $Year, 
        $Price]);
    }

    protected function getColors(){
      $sql = "SELECT * FROM `Allowed Colors`";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    protected function getMakers(){
      $sql = "SELECT * FROM `Allowed Makers`";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

  }
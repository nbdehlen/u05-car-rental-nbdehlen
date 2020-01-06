<?php
  namespace Main\Core;
  
  use Main\Controllers\ListController;
  use Main\Controllers\InputController;
  use Main\Controllers\MainController;  
  use Main\Controllers\UsersController; 
  use Main\Controllers\CarsController; 
  use Main\Controllers\HistoryController; 
  
  class Router {
    public function route($request, $twig) {
        $path = $request->getPath();
        $form = $request->getForm();

        //echo "path: $path<br>";
        
        if ($path == "/listAll") {
          $controller = new ListController();
          $htmlCode = $controller->listAll($twig);
          return $htmlCode;
        }
        else if ($path == "/carsAll") {
          $controller = new CarsController();
          $htmlCode = $controller->getCarsCtrl($twig);
          return $htmlCode;
        }

        else if ($path == "/CarAdd") {
          $controller = new CarsController();
          return $controller->carAdd($twig);
        }

        else if ($path == "/inputIndex") {
          $controller = new InputController();
          return $controller->inputIndex($twig);
        }
        else if ($path == "/listIndex") {
          $controller = new ListController();
          $firstIndex = $form["firstIndex"];
          $lastIndex = $form["lastIndex"];
          return $controller->listIndex($twig, $firstIndex, $lastIndex);
        }
        else if ($path == "/UserAdd") {
          $controller = new UsersController();
          return $controller->UserAdd($twig);
          /*, $PersonNumber, $Name, $Address, $PostalAddress, 
          $PhoneNumber);*/
        }
        else if ($path == "/" || $path == "/usersAll") {
          $controller = new UsersController();
          $htmlCode = $controller->getUser($twig);
          return $htmlCode;
        }
        else if ($path == "/CheckOut") {
          $controller = new HistoryController();
          return $controller->checkOut($twig);
        }
        else if ($path == "/CheckIn") {
          $controller = new HistoryController();
          return $controller->checkIn($twig);
        }
        else if (preg_match("/^\/(CarEdit)/", $path)) {
          $controller = new CarsController();
          return $controller->getCarCtrl($twig);
        }
        else if (preg_match("/^\/(CarRemove)/", $path)) {
          $controller = new CarsController();
          return $controller->removeCar($twig);
        }

        else {
          return "Router Error!";
        }
    }
  }
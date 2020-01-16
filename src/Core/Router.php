<?php
  namespace Main\Core;
 
  use Main\Controllers\UsersController; 
  use Main\Controllers\CarsController; 
  use Main\Controllers\HistoryController; 
  
  class Router {
    public function route($request, $twig) {
        $path = $request->getPath();
        
        if ($path == "/CarsAll") {
          $controller = new CarsController();
          return $controller->getCarsCtrl($twig);
        }
        /*else if (preg_match("/^\/(UserAdded)/", $path)
        ||  preg_match("/^\/(UserEdited)/", $path)
         || preg_match("/^\/(UserRemoved)/", $path)) {
          $controller = new UsersController();
          return $controller->userConfirmed($twig);
        }*/
        else if ($path == "/CarAdd") {
          $controller = new CarsController();
          return $controller->carAdd($twig);
        }
        else if ($path == "/UserAdd") {
          $controller = new UsersController();
          return $controller->UserAdd($twig);
        }
        else if ($path == "/" || $path == "/usersAll") {
          $controller = new UsersController();
          return $controller->getUser($twig);
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
        else if ($path == "/HistoryAll") {
          $controller = new HistoryController();
          return $controller->displayHistory($twig);
        }
        else if (preg_match("/^\/(UserEdit)/", $path)) {
          $controller = new UsersController();
          return $controller->getUserCtrl($twig);
        }
        else if (preg_match("/^\/(UserRemove)/", $path)) {
          $controller = new UsersController();
          return $controller->removeUser($twig);
        }
        else {
          return "Ingen match i routern";
        }
    }
  }
<?php
  namespace Main\Core;
  
  use Main\Controllers\ListController;
  use Main\Controllers\InputController;
  use Main\Controllers\MainController;  
  use Main\Controllers\UsersController; 
  use Main\Controllers\CarsController; 
  
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
       /* else if ($path == "/") {
          $controller = new MainController();
          return $controller->mainMenu($twig);
        }*/
        else if ($path == "/" || $path == "/usersAll") {
          $controller = new UsersController();
          $htmlCode = $controller->getUser($twig);
          return $htmlCode;
        } else {
          return "Router Error!";
        }
    }
  }
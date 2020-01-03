<?php

namespace Main\Controllers;
use Main\Core\Model;

class UsersController extends Model {
    //Why we go into a separate class just to make a function to run another function?
    //Why do we need to reroute it through our user controller?
    //For security and to follow MVC model so UsersContr doesnt directly
    //reference to the users class.
    //Second reason is if we have multiple tables or classes this is an easier way
    public function createUser($PersonNumber, $Name, $Address, $PostalAddress, 
    $PhoneNumber) {
        $personArray = $this->setUser($PersonNumber, $Name, $Address, 
        $PostalAddress, $PhoneNumber);
        
        $form = $this->request->getForm();

        
    }

    public function getUser($twig) {
        $personArray = $this->getAll();
        $map = ["personArray" => $personArray];
        return $twig->loadTemplate("usersAll.twig")->render($map);
    }

}

  
/*class MainController {
    public function mainMenu($twig) {
      $emptyMap = [];
      return $twig->loadTemplate("test.twig")->render($emptyMap);
    }
}*/

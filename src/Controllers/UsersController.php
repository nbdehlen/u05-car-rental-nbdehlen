<?php

namespace Main\Controllers;
use Main\Core\Request;
use Main\Core\Model;

class UsersController extends Model {
    //Why we go into a separate class just to make a function to run another function?
    //Why do we need to reroute it through our user controller?
    //For security and to follow MVC model so UsersContr doesnt directly
    //reference to the users class.
    //Second reason is if we have multiple tables or classes this is an easier way
    public function userAdd($twig) {
        if (isset($_POST['PersonNumber'])) {
            $this->createUser();
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        } else {
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        }
    }
    
    public function createUser(/*$twig*/) {
        echo "accessing createUser function";
       /* $form = new request;
        $form->getForm();
        var_dump($form->getForm());

        $map = ["" => $];*/
        $PersonNumber = $_POST['PersonNumber'];
        $Name = $_POST['FullName'];
        $Address = $_POST['Address'];
        $PostalAddress = $_POST['PostalAddress'];
        $PhoneNumber = $_POST['telefonnummer'];
        $this->setUser($PersonNumber, $Name, $Address, $PostalAddress, $PhoneNumber);
        //$this->setUser($PersonNumber, $Name, $Address, $PostalAddress, $PhoneNumber);

        //return $twig->loadTemplate("UserAdd.twig")->render($form);
    }

    public function getUser($twig) { //should rename this
        $personArray = $this->getAll();
        $map = ["personArray" => $personArray];
        return $twig->loadTemplate("usersAll.twig")->render($map);
    }

        //Get selected User for Edit
        public function getUserCtrl($twig) {
            $pn = explode("/", $_SERVER['REQUEST_URI']);
            var_dump($pn);

            $map = [
            "pn" => $pn[2],
            "name" => str_replace("%20"," ", $pn[3]),
            "address" => str_replace("%20"," ", $pn[4]),
            "phone" => $pn[5],
            "postal" => str_replace("%20"," ", $pn[6])];
            //var_dump($_SERVER['REQUEST_URI']);
    
            if (isset($_POST['postal'])) {
                $this->editUser();
                //var_dump($_POST);
                return $twig->loadTemplate("UserEdit.twig")->render($map);
            } else {
                return $twig->loadTemplate("UserEdit.twig")->render($map);
            }
        
        }
        //get post values to send to model
        public function editUser() {
            $pn = $_POST['pn'];
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $postal = $_POST['postal'];
            
    
            $this->setUserEdit($name, $address, $phone, $postal, $pn);
        }

}

  
/*class MainController {
    public function mainMenu($twig) {
      $emptyMap = [];
      return $twig->loadTemplate("test.twig")->render($emptyMap);
    }
}*/

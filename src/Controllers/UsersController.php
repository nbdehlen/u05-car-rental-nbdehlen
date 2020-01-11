<?php
namespace Main\Controllers;
use Main\Core\Model;

class UsersController extends Model {

    /* Displaying list of users and calling createUser function
       if the form has successfully been sent */
    public function userAdd($twig) {
        if (isset($_POST['PersonNumber'])) {
            $this->createUser();
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        } else {
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        }
    }
    //Sending data back to model to add customer
    public function createUser() {
        $PersonNumber = $_POST['PersonNumber'];
        $Name = $_POST['FullName'];
        $Address = $_POST['Address'];
        $PostalAddress = $_POST['PostalAddress'];
        $PhoneNumber = $_POST['telefonnummer'];
        $this->setUser($PersonNumber, $Name, $Address, $PostalAddress, $PhoneNumber);
    }

    //Populate customers view and disable if currently renting
    public function getUser($twig) {
        $personArray = $this->getAllUsers();
        $map = ["personArray" => $personArray];
    
        return $twig->loadTemplate("usersAll.twig")->render($map);
    }

        //Get selected User for Edit
        public function getUserCtrl($twig) {
            $pn = explode("/", utf8_encode($_SERVER['REQUEST_URI']));

            //Replace html characters with Å Ä Ö and whitespace
            $replaceSwe = ["%C3%A5" => "å", '%C3%A4'=> "ä","%C3%B6" => "ö", 
            "%C3%85" => "Å", "%C3%84" => "Ä", "%C3%96" => "Ö", "%20" => " "];

            for ($i=0; $i<count($pn); $i++) {
               $cleanPn[$i] = str_replace(array_keys($replaceSwe), $replaceSwe, $pn[$i]);
            }

            $map = [
            "pn" => $cleanPn[2],
            "name" => $cleanPn[3],
            "address" => $cleanPn[4],
            "phone" => $cleanPn[5],
            "postal" => $cleanPn[6]];
    
            if (isset($_POST['postal'])) {
                $this->editUser();
            return $twig->loadTemplate("userEdit.twig")->render($map);
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

            //Remove user
    public function removeUser($twig) {
        $regExplode = explode("/", $_SERVER['REQUEST_URI']);
        $pn = $regExplode[2];
        echo "användare borttagen";
        $this->setUserRemove($pn);
        return $twig->loadTemplate("usersAll.twig")->render([]);
    }
}
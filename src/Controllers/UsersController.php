<?php
namespace Main\Controllers;
use Main\Core\Model;

class UsersController extends Model {

    public function userAdd($twig) {
        if (isset($_POST['PersonNumber'])) {
            $this->createUser();
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        } else {
            return $twig->loadTemplate("UserAdd.twig")->render([]);
        }
    }
    
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
            $pn = explode("/", $_SERVER['REQUEST_URI']);

            $map = [
            "pn" => $pn[2],
            "name" => str_replace("%20"," ", $pn[3]),
            "address" => str_replace("%20"," ", $pn[4]),
            "phone" => $pn[5],
            "postal" => str_replace("%20"," ", $pn[6])];
    
            if (isset($_POST['postal'])) {
                $this->editUser();
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

            //Remove user
    public function removeUser($twig) {
        $regExplode = explode("/", $_SERVER['REQUEST_URI']);
        $pn = $regExplode[2];
        echo "användare borttagen";
        $this->setUserRemove($pn);
        return $twig->loadTemplate("usersAll.twig")->render([]);
    }
}
<?php
namespace Main\Controllers;

use Main\Core\Model;

class CarsController extends Model {
    public function getCarsCtrl($twig) {
        $carArray = $this->getCars();
        $map =[ "carArray" => $carArray];
        return $twig->loadTemplate("CarsAll.twig")->render($map);
    }

    public function carAdd($twig) {
        $Colors = $this->getColors();
        $Makers = $this->getMakers();
        $map = ["getColors" => $Colors, "getMakers" => $Makers];

        if (isset($_POST['Registration'])) {
            $this->createCar();
            return $twig->loadTemplate("CarAdded.twig")->render($_POST);
        } else {
            return $twig->loadTemplate("CarAdd.twig")->render($map);
        }
    }

    public function createCar() {
        $Registration = $_POST['Registration'];
        $Make = $_POST['Make'];
        $Color = $_POST['Color'];
        $Year = $_POST['Year'];
        $Price = $_POST['Price'];
        $this->setCar($Registration, $Make, $Color, $Year, $Price);
    }

    //Get selected Car for Edit
    public function getCarCtrl($twig) {
        $reg = explode("/", $_SERVER['REQUEST_URI']);
        $Colors = $this->getColors();
        $Makers = $this->getMakers();

        $map = [
        "reg" => $reg[2],
        "preMake" => $reg[3],
        "preColor" => $reg[4],
        "getColors" => $Colors, 
        "getMakers" => $Makers];

        if (isset($_POST['Year'])) {
            $this->editCar();
            return $twig->loadTemplate("CarEdited.twig")->render($_POST);
        } else {
            return $twig->loadTemplate("CarEdit.twig")->render($map);
        }
    }

    //get post values to send to model
    public function editCar() {
        $reg = $_POST['Registration'];
        $make = $_POST['Make'];
        $color = $_POST['Color'];
        $year = $_POST['Year'];
        $price = $_POST['Price'];
        $this->setCarEdit($make, $color, $year, $price, $reg);
    }

    //Remove car
    public function removeCar($twig) {
        $regExplode = explode("/", $_SERVER['REQUEST_URI']);
        $reg = $regExplode[2];
         $this->setCarRemove($reg);
        //return $twig->loadTemplate("CarsAll.twig")->render([]);
        return $this->getCarsCtrl($twig);
    }
}
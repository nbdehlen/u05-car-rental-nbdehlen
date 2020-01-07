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
            return $twig->loadTemplate("CarAdd.twig")->render($map);
        } else {
            return $twig->loadTemplate("CarAdd.twig")->render($map);
        }
    }

    public function createCar() {
        echo "accessing createCar function";
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
        var_dump($reg[2]);
        $Colors = $this->getColors();
        $Makers = $this->getMakers();
        //$regplate = $reg[2];
        //$regFunc = $this->getReg($regplate);
        //var_dump($regFunc);
        $map = [
        "reg" => $reg[2],
        "preMake" => $reg[3],
        "preColor" => $reg[4],
        "getColors" => $Colors, 
        "getMakers" => $Makers];
        //$carArray = getCarEdit($reg);
        //$map =[ "carArray" => $carArray];
        //var_dump($_SERVER['REQUEST_URI']);

        if (isset($_POST['Year'])) {
            $this->editCar();
            //var_dump($_POST);
            return $twig->loadTemplate("CarEdit.twig")->render($map);
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
        //$reg = $_POST['Registration'];
        $regExplode = explode("/", $_SERVER['REQUEST_URI']);
        //var_dump($regExplode);
        $reg = $regExplode[2];

        if ($regExplode[3] == "Free") {
            //echo "Bil borttagen";
            $this->setCarRemove($reg);
            return $twig->loadTemplate("CarsAll.twig")->render([]);
        }
        //
        //$this->setCarRemove($reg);
        else {
           // echo "Bilen är för närvarande uthyrd";
            return $twig->loadTemplate("CarsAll.twig")->render([]);
    }
    }
}
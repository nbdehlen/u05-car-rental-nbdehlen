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
            echo "CreateUser osv";
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
        var_dump($reg[3]);
        var_dump($reg[4]);
        $Colors = $this->getColors();
        $Makers = $this->getMakers();
        $map = [
        "reg" => $reg[2],
        "preMake" => $reg[3],
        "preColor" => $reg[4],
        "getColors" => $Colors, 
        "getMakers" => $Makers];
        //$carArray = getCarEdit($reg);
        //$map =[ "carArray" => $carArray];
        //var_dump($_SERVER['REQUEST_URI']);
    return $twig->loadTemplate("CarEdit.twig")->render($map);
    }
    
    public function editCar($reg) {
        
    }
}
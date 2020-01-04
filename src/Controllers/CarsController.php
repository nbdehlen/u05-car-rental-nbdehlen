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
        var_dump($map);
        if (isset($_POST['Registration'])) {
            echo "CreateUser osv";
            var_dump($_POST);
            $this->createCar();
            return $twig->loadTemplate("CarAdd.twig")->render($map);
        } else {
            return $twig->loadTemplate("CarAdd.twig")->render($map);
        }
    }

    public function createCar(/*$twig*/) {
        echo "accessing createCar function";
        $Registration = $_POST['Registration'];
        $Make = $_POST['Make'];
        $Color = $_POST['Color'];
        $Year = $_POST['Year'];
        $Price = $_POST['Price'];

        $this->setUser($Registration, $Make, $Color, $Year, $Price);
    }

}
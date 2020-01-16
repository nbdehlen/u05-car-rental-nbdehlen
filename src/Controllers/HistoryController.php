<?php
namespace Main\Controllers;
use Main\Core\Request;
use Main\Core\Model;

class HistoryController extends Model {

    /* checkOutCar function needs to run before fetching the list of free 
       cars from the model to reflect that the car is no longer available to rent */
    public function checkOut($twig) {
         if (isset($_POST['pr'])) {
            $this->checkOutCar();
        }
            $getReg = $this->getRegFree();
            $getPr = $this->getPr();
            $map = ["getReg" => $getReg, "getPr" => $getPr];
            return $twig->loadTemplate("CheckOut.twig")->render($map);
    }

    public function checkOutCar() {
        $rentedBy = $_POST['pr'];
        $reg  = $_POST['reg'];
        $this->setCheckOutTime($rentedBy, $reg);
    }
    
    /* Same principle as checkOut function */
    public function checkIn($twig){
        if (isset($_POST['reg'])) {
            $reg = $_POST['reg'];
            $this->setRegReturned($reg);
        }
        $getRegRented = $this->getRegRented();
        $map = ["getRegRented" => $getRegRented];
        return $twig->loadTemplate("CheckIn.twig")->render($map);
    }

    public function displayHistory($twig) {
        $historyPrice = $this->getConvertions();
        $map = ["historyPrice" => $historyPrice];

    return $twig->loadTemplate("HistoryAll.twig")->render($map);
    }
}
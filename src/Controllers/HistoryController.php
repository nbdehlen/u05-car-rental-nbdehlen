<?php
namespace Main\Controllers;
use Main\Core\Request;
use Main\Core\Model;

class HistoryController extends Model {

    public function checkOut($twig) {
        $getReg = $this->getRegFree();
        $getPr = $this->getPr();
        $map = ["getReg" => $getReg, "getPr" => $getPr];

        if (isset($_POST['pr'])) {
            echo "checking out!";
            $this->checkOutCar();
            return $twig->loadTemplate("CheckOut.twig")->render($map);
        }
        else {
            return $twig->loadTemplate("CheckOut.twig")->render($map);
        }
    }

    public function checkOutCar() {
        $rentedBy = $_POST['pr'];
        $reg  = $_POST['reg'];
        echo $rentedBy . ' ' . $reg;
        $this->setCheckOutTime($rentedBy, $reg);
    }

    public function checkIn($twig){
        $getRegRented = $this->getRegRented();
        $map = ["getRegRented" => $getRegRented];

        if (isset($_POST['reg'])) {
            //var_dump($_POST);
            $reg = $_POST['reg'];
            $this->setRegReturned($reg);
        }
        return $twig->loadTemplate("CheckIn.twig")->render($map);
    }

    public function displayHistory($twig) {
        //$getHistory = $this->getHistory();
        $historyPrice = $this->getConvertions();
        //var_dump($historyPrice);
        $map = ["historyPrice" => $historyPrice];
           // $map = ["getConv" => $convertions];

    return $twig->loadTemplate("HistoryAll.twig")->render($map);
    }
}
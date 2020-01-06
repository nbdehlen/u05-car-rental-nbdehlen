<?php
namespace Main\Controllers;
use Main\Core\Request;
use Main\Core\Model;

class HistoryController extends Model {
   /* public function checkOut($twig) { //should rename this
        $History = $this->getCheckOut();
        $map = ["History" => $History];
        return $twig->loadTemplate("CheckOut.twig")->render($map);
    }*/

    public function checkOut($twig) {
        $getReg = $this->getRegFree();
        $getPr = $this->getPr();
        //var_dump($getPr);
        //var_dump($getReg);
        //echo "getReg model accessed";
        $map = ["getReg" => $getReg, "getPr" => $getPr];
        if (isset($_POST['pr'])) {
            echo "checking out!";
            $this->checkOutCar();
            return $twig->loadTemplate("CheckOut.twig")->render($map);
        }
        else {
           // var_dump($_POST['Personal number']);
            //var_dump($_POST['Registration']);
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
        /*var_dump($map);*/
        if (isset($_POST['reg'])) {
            echo "Checking in!";
            var_dump($_POST);
            $reg = $_POST['reg'];
            $this->setRegReturned($reg);
            return $twig->loadTemplate("CheckIn.twig")->render($map);
        }
        else {
            echo "NOT checking in!";
            return $twig->loadTemplate("CheckIn.twig")->render($map);
        }
    }

    /*public function createHistory() {
        $pr = $_POST[''];
        $reg = $_POST[''];
        $rentedFrom = $_POST[''];
        $rentedUntil = $_POST[''];
        $this->setRegReturned($pr, $reg, $rentedFrom,
            $rentedUntil, );
    }*/

    public function displayHistory($twig) {
        $getHistory = $this->getHistory();
        $count = $this->getConvertions();
        $map = ["getHistory" => $getHistory,
                "getCount" => $count];
        var_dump($map);
    return $twig->loadTemplate("HistoryAll.twig")->render($map);
    }

}

/*
Checkin:

1. get dropdown list: bilar som är uthyrda XXX
2. set:
    Regnummer från Cars matchande personnummer Rentedby
    Personnummer från Cars matchande 

    Antal påbörjade dygn bilen var uthyrd
    cost (days*price)
    JS: totala kostnaden
*/
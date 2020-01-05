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

}

/*
Checkout:
1. Send in dropdowns XXX

2. Change value in Cars `Rented from` to a js date
    Change value in cars `Rented by` to Personnummer selected

3. Set Registration



*/
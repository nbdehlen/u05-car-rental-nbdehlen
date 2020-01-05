<?php
namespace Main\Controllers;
use Main\Core\Request;
use Main\Core\Model;

class HistoryController extends Model {
    public function checkOut($twig) { //should rename this
        $History = $this->getCheckOut();
        $map = ["History" => $History];
        return $twig->loadTemplate("CheckOut.twig")->render($map);
    }
}
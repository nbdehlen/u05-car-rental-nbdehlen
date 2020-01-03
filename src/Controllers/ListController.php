<?php
  namespace Main\Controllers;
  
  use Main\Core\Model;
  
  class ListController {
      public function listAll($twig) {
        $model = new Model();
        $personArray = $model->getAll();
        $map = ["personArray" => $personArray];
        $htmlCode = $twig->loadTemplate("ListAllView.twig")->render($map);
        return $htmlCode;
      }

      public function listIndex($twig, $firstIndex, $lastIndex) {
        $model = new Model();
        $personArray = $model->getInterval($firstIndex, $lastIndex);
        $map = ["personArray" => $personArray, "firstIndex" => $firstIndex, "lastIndex" => $lastIndex];
        $htmlCode = $twig->loadTemplate("ListIndexView.twig")->render($map);
        return $htmlCode;
      }

      /*public function listIndex($twig, $firstIndex, $lastIndex) {
        $model = new Model();
        $subPersonArray = $model->getInterval($firstIndex, $lastIndex);
        $map = ["subPersonArray" => $subPersonArray, "firstIndex" => $firstIndex, "lastIndex" => $lastIndex];
        $htmlCode = $twig->loadTemplate("ListIndexView.twig")->render($map);
        return $htmlCode;
      }*/
  }
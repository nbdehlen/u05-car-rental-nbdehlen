<?php
  namespace Main\Controllers;
  
  use Main\Core\Model;
  
  class InputController {
      public function inputIndex($twig) {
        $emptyMap = [];
        return $twig->loadTemplate("InputIndexView.twig")->render($emptyMap);
      }
  }
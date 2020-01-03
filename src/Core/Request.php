<?php
  // URL == URI
  // URL: https://www.dn.se/ekonomi/konflikten-trappas-upp-inget-c-more-for-com-hems-kunder/
  // Domän: https://www.dn.se
  // Path: /ekonomi/konflikten-trappas-upp-inget-c-more-for-com-hems-kunder/

  namespace Main\Core;
  
  class Request {
      private $path, $form;
      
      public function __construct() {
        $this->path = $_SERVER["REQUEST_URI"];    // /inputIndex
        $this->form = array_merge($_POST, $_GET); // ["index" => 123]
      }
      
      public function getPath() {
          return $this->path;
      }
    
      public function getForm() {
          return $this->form;
      }
  }
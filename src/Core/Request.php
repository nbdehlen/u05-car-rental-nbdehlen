<?php
  namespace Main\Core;
  
  class Request {
      private $path;
      
      public function __construct() {
        $this->path = $_SERVER["REQUEST_URI"];
      }
      
      public function getPath() {
          return $this->path;
      }
  }
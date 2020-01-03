<?php
namespace Main\Core;
use PDO;

class Config {
    private $host = "localhost";
    private $user = "homestead";
    private $pwd = "secret";
    private $dbName = "car_rental";

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        //You can do this in PDO but mmtuts likes to make things into functions
        $pdo = new PDO($dsn, $this->user, $this->pwd);

        //Optional function for default way of pulling out data
        //so we dont have to define it each time
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
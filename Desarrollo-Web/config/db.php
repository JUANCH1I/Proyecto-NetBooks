<?php

define("DB_HOST", "localhost");
define("DB_NAME", "login");
define("DB_USER", "root");
define("DB_PASS", "");

function conexion(){
 try {
    $con = new PDO('mysql:host=localhost;dbname=login', 'root', '');
    return $con;
 } catch (\Throwable $th){
    return false;
 }
}
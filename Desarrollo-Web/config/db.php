<?php

define("DB_HOST", "");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "!");

function conexion() {
   try {
       $con = new PDO('mysql:host=;dbname=', DB_USER, DB_PASS);
       return $con;
   } catch (PDOException $e) {
       echo "Error de conexión: " . $e->getMessage();
       return false;
   }
}
return [
    'db' => [
      'host' => '',
      'user' => '',
      'pass' => '',
      'name' => '',
      'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]
    ]
  ];

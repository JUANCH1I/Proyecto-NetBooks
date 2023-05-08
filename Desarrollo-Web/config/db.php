<?php

define("DB_HOST", "190.228.29.62");
define("DB_NAME", "bdwebet29");
define("DB_USER", "bdwebet29");
define("DB_PASS", "Tecnica29!");

function conexion() {
   try {
       $con = new PDO('mysql:host=190.228.29.62;dbname=bdwebet29', DB_USER, DB_PASS);
       return $con;
   } catch (PDOException $e) {
       echo "Error de conexión: " . $e->getMessage();
       return false;
   }
}
return [
    'db' => [
      'host' => '190.228.29.62',
      'user' => 'bdwebet29',
      'pass' => 'Tecnica29!',
      'name' => 'bdwebet29',
      'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]
    ]
  ];
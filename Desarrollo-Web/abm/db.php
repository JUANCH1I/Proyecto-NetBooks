<?php

define("DB_HOST", "localhost");
define("DB_NAME", "bdwebet29");
define("DB_USER", "root");
define("DB_PASS", "");

function conexion()
{
  try {
    $con = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    return $con;
  } catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    return false;
  }
}
return [
  'db' => [
    'host' => DB_HOST,
    'user' => DB_USER,
    'pass' => DB_PASS,
    'name' => DB_NAME,
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];

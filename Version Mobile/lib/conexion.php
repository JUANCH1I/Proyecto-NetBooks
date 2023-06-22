<?php

$db_name = "bdwebet29";
$db_server = "190.228.29.62";
$db_user = "bdwebet29";
$db_pass = "Tecnica29!";

$db = new PDO("mysql:host={$db_server};dbname={$db_name};charset=utf8", $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
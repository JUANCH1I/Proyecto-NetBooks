<?php
require_once("config/db.php");
function escapar($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
require_once("templates/header.php");

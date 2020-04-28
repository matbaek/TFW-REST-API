<?php 
@ob_start();

include_once("config/database.php");
include_once("config/functions.php");

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "tfw");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

?>
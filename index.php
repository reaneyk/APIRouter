<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once 'lib/Router.php';
$Router = new Router();
$Router->route();

?>

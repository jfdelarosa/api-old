<?php
require 'flight/Flight.php';

Flight::register('db', 'mysqli', array('localhost', 'root', '', 'api'));
$db = Flight::db();
require 'modules/usuarios/routes.php';

Flight::start();
?>
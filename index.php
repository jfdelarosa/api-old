<?php
require 'flight/Flight.php';

$whitelist = array('127.0.0.1', '::1');

if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
  $mysqli_config = array('localhost', 'root', '', 'api');
}else{
  $mysqli_config = array('mysql.hostmania.es', 'u860838189_root', 'EuA4XRpsJiBH', 'u860838189_pos');
}

Flight::register('db', 'mysqli', $mysqli_config);

$db = Flight::db();
require 'modules/usuarios/routes.php';

Flight::start();
?>
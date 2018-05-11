<?php
require 'flight/Flight.php';
require 'modules/usuarios/routes.php';

Flight::route('/', function(){
  Flight::json(array('body' => 'Hola mundo'));
});

Flight::start();
?>
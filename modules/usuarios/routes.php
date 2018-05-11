<?php
include('controller.php');

Flight::route('GET /usuarios', array('Usuarios', 'get_all'));
Flight::route('POST /usuarios', array('Usuarios', 'new_usuario'));

Flight::route('GET /usuarios/@id', array('Usuarios', 'get_usuario'));

?>
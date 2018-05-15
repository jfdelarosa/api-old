<?php
include('controller.php');

$usuarios = new Usuarios($db);

Flight::route('GET /usuarios', array($usuarios, 'get_all'));
Flight::route('POST /usuarios', array($usuarios, 'new_usuario'));

Flight::route('POST /usuarios/login', array($usuarios, 'login'));

Flight::route('GET /usuarios/@id:[0-9]+', array($usuarios, 'get_usuario'));
Flight::route('PUT /usuarios/@id:[0-9]+', array($usuarios, 'edit_usuario'));
Flight::route("DELETE /usuarios/@id:[0-9]+", array($usuarios, 'delete_usuario'));

?>
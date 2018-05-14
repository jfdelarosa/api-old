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
Flight::route('*', function(){
  GLOBAL $db;
  if(isset($_SERVER['HTTP_TOKEN'])){
    $token = $_SERVER['HTTP_TOKEN'];
    $query = "SELECT * FROM tienda WHERE licencia = '".$token."'";
    if($result = $db->query($query)){
      if($result->num_rows == 1){
        return true;
      }else{
        $response = array(
          'error' => 'El token es invalido',
          'error_code' => 101
        );
      }
    }else{
      $response = array(
        'error' => 'Error al obtener datos del servidor',
        'error_code' => 102
      );
    }
  }else{
    $response = array(
      'error' => 'No se detectó un token de acceso',
      'error_code' => 100
    );
  }
  Flight::json($response);
});
require 'modules/usuarios/routes.php';

Flight::start();
?>
<?php
class Usuarios{
  // /usuarios
  public static function get_all(){
    Flight::json(array('body' => array('usuario 1', 'usuario 2')));
  }

  public static function new_usuario(){
    if(true){
      $response = array('body' => 'usuario creado');
    }else{
      $response = array(
        'error' => 'Hubo un error al crear el usuario',
        'error_code' => 1
      );
    }
    Flight::json($response);
  }

  // /usuarios/$id
  public static function get_usuario($id){
    if(true){
      $response = array('body' => 'usuario ' . $id);
    }else{
      $response = array(
        'error' => 'Hubo un error al obtener el usuario',
        'error_code' => 2
      );
    }
    Flight::json($response);
  }
}
?>
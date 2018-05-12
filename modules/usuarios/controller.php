<?php
class Usuarios{

  public $db;
  public $tienda_id;

  function __construct($db){
    $this->db = $db;
    $this->tienda_id = 1;
  }
  // GET /usuarios
  public function get_all(){
    $query = "SELECT * FROM usuarios WHERE tienda_id = " . $this->tienda_id;
    if($result = $this->db->query($query)){
      $response = array('body' => $result->fetch_assoc());
    }else{
      $response = array(
        'error' => 'Hubo un error al obtener los usuarios',
        'error_code' => 1
      );
    }
    Flight::json($response);
  }

  // POST /usuarios
  public function new_usuario(){
    if(true){
      $response = array('body' => 'usuario creado');
    }else{
      $response = array(
        'error' => 'Hubo un error al crear el usuario',
        'error_code' => 2
      );
    }
    Flight::json($response);
  }

  // GET /usuarios/$id
  public function get_usuario($id){
    if(true){
      $response = array('body' => 'usuario ' . $id);
    }else{
      $response = array(
        'error' => 'Hubo un error al obtener el usuario ' . $id,
        'error_code' => 3
      );
    }
    Flight::json($response);
  }

  // PUT /usuarios/$id
  public function edit_usuario($id){
    if(true){
      $response = array('body' => 'usuario ' . $id);
    }else{
      $response = array(
        'error' => 'Hubo un error al editar el usuario ' . $id,
        'error_code' => 4
      );
    }
    Flight::json($response);
  }

  // DELETE /usuarios/$id
  public function delete_usuario($id){
    if(true){
      $response = array('body' => 'usuario ' . $id);
    }else{
      $response = array(
        'error' => 'Hubo un error al eliminar el usuario ' . $id,
        'error_code' => 5
      );
    }
    Flight::json($response);
  }

  public function login(){
    if(isset($_GET['u']) && isset($_GET['p'])){
      $usuario = $_GET['u'];
      $pass = $_GET['p'];
      $query = "SELECT id, username, password FROM usuarios WHERE username = '" . $usuario . "' AND tienda_id = '" . $this->tienda_id . "'";
      if($result = $this->db->query($query)){
        if($result->num_rows() == 1){
          $row = $result->fetch_assoc();
          // TODO: add hash function
          if($pass == $row['hash']){
            $query = "SELECT * FROM usuarios WHERE id = '" . $row['id'] . "' AND tienda_id = '" . $this->tienda_id . "'";
            if($result = $this->db->query($query)){
              $response = array('body' => $result->fetch_assoc());
            }else{
              $response = array(
                'error' => 'El login funcionó, pero hubo un error desconocido',
                'error_code' => 1
              );
            }
          }else{
            $response = array(
              'error' => 'Las contraseñas no coinciden',
              'error_code' => 1
            );
          }
        }else{
          $response = array(
            'error' => 'El usuario no existe',
            'error_code' => 1
          );
        }
  
      }else{
        $response = array(
          'error' => 'Hubo un error al obtener los usuarios',
          'error_code' => 1
        );
      }
    }else{
      $response = array(
        'error' => 'No se recibieron los parámetros requeridos',
        'error_code' => 1
      );
    }
    Flight::json($response);
  }
}
?>
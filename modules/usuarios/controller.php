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
    $query = "SELECT usuarios.id, usuarios.username, usuarios.nombre, roles.nombre AS rol, roles.id AS rol_id FROM usuarios
    JOIN roles on roles.id = usuarios.rol_id AND usuarios.tienda_id = '" . $this->tienda_id . "'";
    if($result = $this->db->query($query)){
      for($set = array(); $row = $result->fetch_assoc(); $set[] = $row);
      $response = array('body' => $set);
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
    $error = false;
    $post_keys = array('rol_id', 'username', 'nombre', 'password');
    $clean = array();
    foreach($post_keys as $key){
      if(isset($_POST[$key]) && $_POST[$key] != ""){
        $clean[$key] = $_POST[$key];
      }else{
        $error = true;
        break;
      }
    }

    if(!$error){

      $query = "SELECT id FROM roles WHERE id = '".$clean['rol_id']."' AND tienda_id = '".$this->tienda_id."'";
      if($result = $this->db->query($query)){
        if($result->num_rows == 1){
          $query = "INSERT INTO usuarios (rol_id, username, nombre, password, tienda_id) VALUES ('".$clean['rol_id']."', '".$clean['username']."', '".$clean['nombre']."', '".$clean['password']."', '".$this->tienda_id."')";
          if($result = $this->db->query($query)){
            $response = array('body' => 'usuario creado');
          }else{
            $response = array(
              'error' => 'Hubo un error al crear el usuario',
              'error_code' => 2
            );
          }
        }else{
          $response = array(
            'error' => 'No se encontró el rol especificado',
            'error_code' => 2
          );
        }
      }else{
        $response = array(
          'error' => 'hubo un error al buscar el rol especificado',
          'error_code' => 2
        );
      }
    }else{
      $response = array(
        'error' => 'No se enviaron los campos corresspondentes',
        'error_code' => 2
      );
    }
    Flight::json($response);
  }

  // GET /usuarios/$id
  public function get_usuario($id){
    $query = "SELECT usuarios.id, usuarios.username, usuarios.nombre, usuarios.password, roles.nombre AS rol, roles.id AS rol_id FROM usuarios
    JOIN roles ON roles.id = usuarios.rol_id AND usuarios.id = '" . $id . "' AND usuarios.tienda_id = '" . $this->tienda_id . "'";
    if($result = $this->db->query($query)){
      if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        $query = "SELECT permisos.nombre as permiso FROM permisos JOIN roles_permisos ON roles_permisos.permiso_id = permisos.id AND roles_permisos.roles_id = '". $user['rol_id'] ."'";
        $result = $this->db->query($query);
        for($set = array(); $row = $result->fetch_assoc(); $set[] = $row);
        $user['permisos'] = $set;
        $response = array('body' => $user);
      }else{
        $response = array(
          'error' => 'No se encontró al usuario ' . $id,
          'error_code' => 3
        );
      }
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
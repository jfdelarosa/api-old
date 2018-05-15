<?php
class Usuarios{

  public $db;
  public $debug;
  public $tienda_id;

  function __construct($db){
    $this->db = $db;
    $this->tienda_id = 1;
    $this->debug = true;
  }

  // GET /usuarios
  public function get_all(){
    $cols = array('u.id', 'u.username', 'u.nombre', 'r.nombre rol', 'r.id rol_id');
    $this->db->join("roles r", "r.id = u.rol_id", "LEFT");
    if($result = $this->db->get("usuarios u", null, $cols)){
      $response = array('body' => $result);
    }else{
      $response = array(
        'error' => 'Hubo un error al obtener los usuarios',
        'error_code' => 200
      );
    }
    Flight::json($response);
  }

  // POST /usuarios
  public function new_usuario(){
    $error = false;
    $clean = array();
    foreach($_POST as $key => $value){
      if(isset($_POST[$key]) && $_POST[$key] != ""){
        $clean[$key] = $value;
      }else{
        $error = true;
        break;
      }
    }
    if(!$error){
      $data = array('rol_id' => $clean['rol_id'],
        'username' => $clean['username'],
        'nombre' => $clean['nombre'],
        'password' => $clean['password'],
        'tienda_id' => $this->tienda_id
      );
      if($db->insert('usuarios', $data)){
        $response = array('body' => 'usuario creado');
      }else{
        $response = array(
          'error' => 'Hubo un error al crear el usuario',
          'error_code' => 211
        );
      }
    }else{
      $response = array(
        'error' => 'Error en los campos correspondentes',
        'error_code' => 210
      );
    }
    Flight::json($response);
  }

  // GET /usuarios/$id
  public function get_usuario($id){
    $cols = array('u.id', 'u.username', 'u.nombre', 'u.password', 'r.nombre rol', 'r.id AS rol_id');
    $this->db->join('roles r', 'r.id = u.rol_id', 'LEFT');
    $this->db->where('u.tienda_id', $this->tienda_id);
    $this->db->where('u.id', $id);

    if($user = $this->db->getOne("usuarios u", $cols)){
      if($this->debug){
        $user['query'][] = $this->db->getLastQuery();
      }
      $this->db->join('roles_permisos rp', 'rp.permiso_id = p.id');
      $this->db->joinWhere('roles_permisos rp', 'rp.roles_id', $user['rol_id']);
      if($result = $this->db->get("permisos p", null, array('p.id', 'p.nombre nombre'))){
        $user['permisos'] = $result;
        if($this->debug){
          $user['query'][] = $this->db->getLastQuery();
        }
        $response = array('body' => $user);
      }else{
        $response = array(
          'error' => 'Hubo un error al obtener los permisos del usuario',
          'error_code' => 221
        );
      }
    }else{
      $response = array(
        'error' => 'Hubo un error al obtener al usuario solicitado',
        'error_code' => 220
      );
    }
    Flight::json($response);
  }

  // PUT /usuarios/$id
  public function edit_usuario($id){
    $put = json_decode(file_get_contents("php://input"), true);

    $error = false;
    $clean = array();
    foreach($put as $key => $value){
      if($put[$key] != ""){
        $clean[$key] = $value;
      }else{
        $error = true;
        break;
      }
    }

    if(!$error){
      $this->db->where('id', $id);
      if($this->db->update('usuarios', $clean)){
        $response = array('body' => 'Usuario editado correctamente');
      }else{
        $response = array(
          'error' => 'Hubo un error al editar el usuario',
          'error_code' => 231
        );
      }
    }else{
      $response = array(
        'error' => 'Error en los campos correspondentes',
        'error_code' => 230
      );
    }

    Flight::json($response);
  }

  // DELETE /usuarios/$id
  public function delete_usuario($id){
    $this->db->where('id', $id);
    if($this->db->delete('usuarios')){
      $response = array('body' => 'Usuario eliminado con éxito');
    }else{
      $response = array(
        'error' => 'Hubo un error al eliminar el usuario ',
        'error_code' => 240
      );
    }
    Flight::json($response);
  }

  public function login(){
    if(isset($_POST['username']) && isset($_POST['password'])){
      $usuario = $_POST['username'];
      $pass = $_POST['password'];

      $this->db->where('username', $usuario);
      $this->db->where('tienda_id', $this->tienda_id);
      if($user = $this->db->getOne('usuarios', array('id', 'username', 'password'))){
        if($pass == $user['password']){
          $this->get_usuario($user['id']);
        }else{
          $response = array(
            'error' => 'Las contraseñas no coinciden',
            'error_code' => 253
          );
        }
      }else{
        $response = array(
          'error' => 'El usuario no existe',
          'error_code' => 252
        );
      }

    }else{
      $response = array(
        'error' => 'No se recibieron los parámetros requeridos',
        'error_code' => 251
      );
    }
    Flight::json($response);
  }
}
?>
<?php
namespace App\model;

use App\Lib\Response,
    App\Lib\Auth;


class AuthModel{
  private $db;
  private $table = 'usuario_persona';
  private $response;

  public function __CONSTRUCT($db){
    $this->db = $db;
    $this->response = new Response();
  }
  public function Autenticar($email, $pass){
    $usuario = $this->db->from($this->table)
                        ->select('id')
                        ->where('email',$email)
                        ->where('pass',md5($pass))
                        ->fetch();

    if (is_object($usuario)) {
      $token = Auth::SignIn([
        'id' =>$usuario->id,
        'nombre'=>$usuario->nombre
      ]);
      $this->response->token = $token;
      $this->response->usuario=$usuario;
      $usuario->pass=':D';
      return $this->response->SetResponse(true);
    }else{
      return $this->response->SetResponse(false, "credenciales no validas");
    }
  }

}
?>

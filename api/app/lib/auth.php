<?php
namespace App\Lib;

use Firebase\JWT\JWT,
     Exception;

class Auth{
  private static $secret_key = 'betiwebmola';
  private static $encrypt = array('HS256');
  private static $aud = null;
  private static $minutes = 60;

  //crea un nuevo token guardando la información del usuario que hemos autenticado
  public static function SignIn($data){
    $time = time();

    $token = array(
        'exp' => $time + (60*self::$minutes),
        'aud' => self::Aud(),
        'data' => $data
    );
    return JWT::encode($token, self::$secret_key);
  }

  //verifica si el token ingresado es valido
  public static function Check($token){
    if (empty($token)) {
      throw new Exception("Invalid token supplied.");
    }

    $decode = JWT::decode(
      $token,
      self::$secret_key,
      self::$encrypt
    );
    if ($decode->aud !== self::AUD()) {
      throw new Exception("Invalid user logged in.");
    }
  }

  //Obtiene la informacion del usuario guardado en el $token
  public static function GetData($token){
    return JWT::decode(
      $token,
      self::$secret_key,
      self::$encrypt
      )->data;
  }

  private static function Aud(){
    $aud ='';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $aud = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $aud = $_SERVER['REMOTE_ADDR'];
    }
    $aud.=@S_SERVER['HTTP_USER_AGENT'];
    $aud .= gethostname();
    return sha1($aud);
  }
}
?>

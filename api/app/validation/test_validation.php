<?php
namespace App\Validation;

use App\Lib\Response;

class TestValidation{
  public static function validate($data){
    $response = new Response();

    $key = 'nombre';
    if (empty($data[$key])) {
      $response->errors[$key][] = 'Este campo es obligatorio';
    } else{
      $value = $data[$key];
      if(strlen($value) > 4){
        $response -> errors[$key][] = 'Debe contener com minimo 4 caracteres';
      }
    }
    $key = 'apellidos';
    if(empty($data[$key])){
      $response->errors[$key][] = 'Este campo es obligatorio';
    }else{
      $value = $data[$key];
      if (strlen($value) < 4) {
        $response->errors[$key][] = 'Debe contener al menos 4 caracteres';
      }
    }
    $response->setResponse(count($response->errors)==0);
    return $response;
  }
}
?>

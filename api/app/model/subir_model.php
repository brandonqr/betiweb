<?php
namespace App\model;

use App\Lib\Response;

class SubirModel{
  private $db;
  private $table = 'producto';
  private $response;
  private $directorio='../uploads/img/';

  public function __CONSTRUCT($db){
    $this->db = $db;
    $this->response = new Response();
  }
  

  public function AgregarImagen($imagen, $usuario_id, $producto_id ){
     if( $imagen -> getError() === UPLOAD_ERR_OK ){
        $uploadFileName = $imagen->getClientFilename();
        $type = $imagen->getClientMediaType();
        $name = uniqid('img-'.date('Ymd').'-');
        $name .=$imagen->getClientFilename();
        $imagenFinal=$this->directorio.$name;
        $imagen->moveTo($imagenFinal);

        var_dump($imagenFinal);
        $producto['imagen'] = $imagenFinal;

        $this->db->update('producto', $producto, $producto_id)
             ->execute();
     }

/*

    //actualizar producto
    $this->db->update('producto', $producto, $producto_id)
             ->execute();
     return $this->response->SetResponse(true);
     */
     
  }
}
?>
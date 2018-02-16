<?php
namespace App\model;

use App\Lib\Response;

class ProductoModel{
  private $db;
  private $table = 'producto';
  private $response;
  private $directorio='../uploads/img/';

  public function __CONSTRUCT($db){
    $this->db = $db;
    $this->response = new Response();
  }
  /*
    Select u.nombre, pi.titulo, pi.descripcion
    from usuario_persona u
    JOIN producto p
    ON u.id = p.usuario_id
    JOIN producto_idioma pi
    ON p.id=pi.producto_id
    JOIN idiomas i
    ON pi.idioma_id = i.id
    where i.idioma_codigo = 'en'
    AND u.id='1'
  */
  public function ListarMisProductos($usuario_id,$idioma_codigo){
    $producto =$this->db->from('producto p')
                    ->select('p.imagen, pi.titulo, pi.descripcion')
                    ->leftJoin("usuario_persona u ON p.usuario_id = u.id")
                    ->leftJoin("producto_idioma pi ON p.id=pi.producto_id")
                    ->leftJoin("idiomas i ON pi.idioma_id = i.id")
                    //->where('i.idioma_codigo',$idioma_codigo)
                    ->where('u.id',$usuario_id)
                     ->fetchAll();//cuando queremos retornar varios registros.
                     
                     $this->response->producto = $producto;
                    // $this->response->producto['pass']='aa';
                     return $this->response->SetResponse(true);
  }
  public function ListarProductos($idioma_codigo){
    return $this->db->from('usuario_persona u')
                    ->select('u.nombre, pi.titulo, pi.descripcion')
                    ->leftJoin("producto p ON u.id = p.usuario_id")
                    ->leftJoin("producto_idioma pi ON p.id=pi.producto_id")
                    ->leftJoin("idiomas i ON pi.idioma_id = i.id")
                    ->where('i.idioma_codigo',$idioma_codigo)
                     ->fetchAll();//cuando queremos retornar varios registros.
  }
  public function ListarMisProductosPorId($usuario_id,$producto_id,$idioma_codigo){
    return $this->db->from('usuario_persona u')
                    ->select('u.nombre, pi.titulo, pi.descripcion')
                    ->leftJoin("producto p ON u.id = p.usuario_id")
                    ->leftJoin("producto_idioma pi ON p.id=pi.producto_id")
                    ->leftJoin("idiomas i ON pi.idioma_id = i.id")
                    ->where('i.idioma_codigo',$idioma_codigo)
                    ->where('u.id',$usuario_id)
                    ->where('p.id',$producto_id)

                     ->fetchAll();//cuando queremos retornar varios registros.

  }

  public function ListarProducto($producto_id, $idioma_codigo){
    return $this->db->from('usuario_persona u')
                    ->select('u.nombre, pi.titulo, pi.descripcion')
                    ->leftJoin("producto p ON u.id = p.usuario_id")
                    ->leftJoin("producto_idioma pi ON p.id=pi.producto_id")
                    ->leftJoin("idiomas i ON pi.idioma_id = i.id")
                    ->where('i.idioma_codigo',$idioma_codigo)
                    ->where('p.id',$producto_id)
                     ->fetchAll();//cuando queremos retornar varios registros.
  }
  public function ultimoId(){
        $producto=$this->db->from('producto')
                          ->select('id')
                          ->orderBy('id desc')
                          ->limit(1)
                         ->fetchAll();//cuando queremos retornar varios registros.
      return $producto[0]->id;

  }
  public function idIdioma($idioma_codigo){
        $idioma=$this->db->from('idiomas')
                          ->select('id')
                          ->where('idioma_codigo',$idioma_codigo)
                         ->fetch();//cuando queremos retornar varios registros.
      return $idioma->id;

  }
  public function CrearProducto($data/*, $imagen*/){
    /*
    var_dump($imagen);
      if( $imagen -> getError() === UPLOAD_ERR_OK ){
        $uploadFileName = $imagen->getClientFilename();
        $type = $imagen->getClientMediaType();
        $name = uniqid('img-'.date('Ymd').'-');
        $name .=$imagen->getClientFilename();
        $imagenFinal=$this->directorio.$name;
        $imagen->moveTo($imagenFinal);
      }*/
    //$producto
    
    $producto['usuario_id']=$data['usuario_id'];
    $producto['categoria_id']=$data['categoria_id'];
    $producto['imagen']='imagenpordefecto.jpg';
    $producto['dimensiones']=$data['dimensiones'];
    $producto['precio_min']=$data['precio_min'];
    $producto['precio_max']=$data['precio_max'];
    $this->db->insertInto($this->table, $producto)
            //->lastInsert()
             ->execute();
    //obtener el ultimo id del ultimo producto
    $producto_id = $this->ultimoId();
    $idioma_id = $this->idIdioma($data['idioma_codigo']);

    $producto_idioma['titulo']=$data['titulo'];
    $producto_idioma['descripcion']=$data['descripcion'];
    $producto_idioma['producto_id']=$producto_id;
    $producto_idioma['idioma_id']=$idioma_id;
    $this->db->insertInto('producto_idioma', $producto_idioma)
             ->execute();

      $this->response->producto = $producto;
      $this->response->producto['producto_id'] = $producto_id;
     // $this->response->usuario=$usuario;
             
     return $this->response->SetResponse(true);
  }

  public function existeIdioma($producto_id,$idioma_id){
    $idioma = $this->db->from('producto p')
                    ->select('COUNT(p.id) as total')
                    ->leftJoin("producto_idioma pi ON p.id = pi.producto_id")
                    ->where('p.id',$producto_id)
                    ->where('pi.idioma_id',$idioma_id)
                     ->fetchAll();//cuando queremos retornar varios registros.
  return ($idioma[0]->total>0)?true:false;
  }

  public function Actualizar($data, $usuario_id, $producto_id, $idioma_codigo){
    $idioma_id=$this->idIdioma($idioma_codigo);

    //var_dump($data);
    //$producto['usuario_id'] = $usuario_id;
    $producto['categoria_id'] = $data['categoria_id'];
    $producto['imagen'] = $data['imagen'];
    $producto['dimensiones'] = $data['dimensiones'];
    $producto['precio_min'] = $data['precio_min'];
    $producto['precio_max']= $data['precio_max'];

    //actualizar producto
    $this->db->update('producto', $producto, $producto_id)
             ->execute();
    //comprar si existe un idioma en ese producto
    $existeIdioma=$this->existeIdioma($producto_id,$idioma_id);

    $producto_idioma['titulo']=$data['titulo'];
    $producto_idioma['descripcion']=$data['descripcion'];
    $producto_idioma['producto_id']=$producto_id;
    $producto_idioma['idioma_id']=$idioma_id;

    if($existeIdioma){//actualizar
      $this->db->update('producto_idioma', $producto_idioma)
                ->where('producto_id',$producto_id)
                ->where('idioma_id',$idioma_id)
               ->execute();

    }else{//insertar
      $this->db->insertInto('producto_idioma', $producto_idioma)
               ->execute();

    }



     return $this->response->SetResponse(true);
  }

  public function Eliminar($data){
    //eliminar producto
    var_dump($data);
    $this->db->deleteFrom($this->table, $data)
             ->execute();
    //Eliminar producto idioma
     $this->db->deleteFrom('producto_idioma')
              ->where('producto_id',$data)
              ->execute();
  //eliminar producto_idioma

     return $this->response->SetResponse(true);
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
     
  }
  public function ListarIdiomas(){
        return $this->db->from('idiomas')
                     ->fetchAll();//cuando queremos retornar varios registros.
                     //$this->response->producto = $producto;
                    // $this->response->producto['pass']='aa';
                   
  }

}
?>

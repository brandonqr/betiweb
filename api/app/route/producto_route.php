<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware,
    App\Middleware\VerificarUsuarioCorrectoMiddleware;

    //doble Middleware verificar login y usuario correcto
$app->group('/producto/', function(){

  $this->get('listarmisproductos/{usuarioid}/{idioma}',function($request, $response, $args){//recibe l=limite, p=pagina
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->producto->ListarMisProductos($args['usuarioid'], $args['idioma']))
                );
  });
  $this->get('listarmisproductos/{usuarioid}/{productoid}/{idioma}',function($request, $response, $args){//recibe l=limite, p=pagina
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->producto->ListarMisProductosPorId($args['usuarioid'],$args['productoid'],$args['idioma']))
                );
  });

  $this->put('actualizar/{usuarioid}/{productoid}/{idioma}', function($request, $response, $args){
    //para testear el actualizar, el formulario tiene que ser
    //x-WWW-form-urlencoded
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->producto->Actualizar($request->getParsedBody(), $args['usuarioid'], $args['productoid'], $args['idioma']))
                );
  });
  $this->delete('eliminar/{usuarioid}/{productoid}', function($request, $response, $args){
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->producto->Eliminar($args['productoid']))
                );
  });
      $this->post('upload/{usuarioid}/{productoid}', function($request, $response, $args){

          $imagen = $request->getUploadedFiles()['imagen'];
        

    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->subir->AgregarImagen( $imagen, $args['usuarioid'], $args['productoid']) ));
                
  });


})->add(new AuthMiddleware($app))
  ->add(new VerificarUsuarioCorrectoMiddleware($app));

  /*Un sólo Middleware, verificar login*/
  $app->group('/producto/', function(){

    $this->post('crearproducto',function($request, $response, $args){//recibe l=limite, p=pagina
      $data = $request->getParsedBody();
      /*
      $files = $request->getUploadedFiles();
      $imagen = $files['imagen'];
*/

      return $response ->withHeader('Content-type', 'application/json')
                  ->write(
                    json_encode($this->model->producto->CrearProducto($data/*, $imagen*/))
                  );
    });

  })->add(new AuthMiddleware($app));

/*Sin Middleware*/
$app->group('/producto/', function(){

    $this->get('listarproductos/{idioma}',function($request, $response, $args){//recibe l=limite, p=pagina
      return $response ->withHeader('Content-type', 'application/json')
                  ->write(
                    json_encode($this->model->producto->ListarProductos($args['idioma']))
                  );
    });

    $this->get('listarproducto/{productoid}/{idioma}',function($request, $response, $args){//recibe l=limite, p=pagina
      return $response ->withHeader('Content-type', 'application/json')
                  ->write(
                    json_encode($this->model->producto->ListarProducto($args['productoid'],$args['idioma']))
                  );
    });
  });

?>

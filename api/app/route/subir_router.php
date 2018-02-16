<?php

use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware,
    App\Middleware\VerificarUsuarioCorrectoMiddleware;

    //doble Middleware verificar login y usuario correcto
$app->group('/upload/', function(){
  


      $this->post('producto/{usuarioid}/{productoid}', function($request, $response, $args){

          $imagen = $request->getUploadedFiles()['imagen'];
        
                //$files = $request->getUploadedFiles();
     // $imagen = $files['imagen'];
     // var_dump($imagen);
    //para testear el actualizar, el formulario tiene que ser
    //x-WWW-form-urlencoded
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->subir->AgregarImagen( $imagen, $args['usuarioid'], $args['productoid']) ));
                
  });
})->add(new AuthMiddleware($app))
  ->add(new VerificarUsuarioCorrectoMiddleware($app));

?>

<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;

$app->group('/test/', function(){
  $this->get('',function($require, $response, $args){
    return $res ->withHeader('Content-type', 'text/html')
                ->write('Soy una ruta de prueba');
  });
  $this->get('empleado/listar/{l}/{p}', function ($require, $response, $args){
    return $res->withHeader('Content-type','application/json')
               ->write(json_encode($this->model->test->getAll(args['l']. args['p'])));
  });
  $this->post('empleado/registrar', function ($require, $response, $args){
    return $res->withHeader('Content-type','application/json')
               ->write(json_encode($this->model->test->insert($require->getParseBody())));
  });
  $this->post('valida', function ($require, $response, $args){
    $r = TestValidation::validate($require->getParsedBody());
    if (!$r->responsive) {

    }
    return $res->withHeader('Content-type','application/json')
               ->write(json_encode($this->model->test->getAll()));
  });
  $this->get('auth', function($require, $responsive, $args){
    $token = Auth::SigIn([
      'nombre' => 'Brandon',
      'correo' => 'brandonqr1@gmail.com',
      'imagen' => null
    ]);
    $res->write($token);
  });
  $this->get('auth/validate',function ($require, $response, $args){
    $res->write('Ok');
  });
});

?>

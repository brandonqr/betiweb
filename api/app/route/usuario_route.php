<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
}
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\UsuarioValidation,
    App\Middleware\AuthMiddleware;

$app->group('/usuario/', function(){
  $this->get('listar',function($require, $response, $args){//recibe l=limite, p=pagina
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->usuario->Listar())
                );
  });

  $this->get('obtener/{id}', function($require, $response, $args){
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->usuario->Obtener($args['id']))
                );
  });


  $this->any('actualizar/{id}', function($require, $response, $args){
    //para testear el actualizar, el formulario tiene que ser
    //x-WWW-form-urlencoded
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->usuario->Actualizar($require->getParsedBody(), $args['id']))
                );
  });

  $this->delete('eliminar/{id}', function($require, $response, $args){
    return $response ->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->usuario->Eliminar($args['id']))
                );
  });
})->add(new AuthMiddleware($app));

$app->post('/usuario/registrar', function($require, $response, $args){
  $r = UsuarioValidation::validate($require->getParsedBody());
  if (!$r->response) {
      return $response ->withHeader('Content-type', 'application/json')
                      ->withStatus(422)
                      ->write(json_encode($r->errors));
  }
  return $response ->withHeader('Content-type', 'application/json')
              ->write(
                json_encode($this->model->usuario->Registrar($require->getParsedBody()))
              );
});
?>

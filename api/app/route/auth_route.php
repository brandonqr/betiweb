<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\UsuarioValidation,
    App\Middleware\AuthMiddleware;

$app->group('/auth/', function(){

  $this->post('autenticar',function($require, $response, $args){//recibe l=limite, p=pagina
    $params = $require->getParsedBody();

    return $response->withHeader('Content-type', 'application/json')
                ->write(
                  json_encode($this->model->auth->Autenticar($params['email'], $params['pass']))
                );
  });
});

?>

<?php
namespace App\Middleware;

use Exception,
    App\Lib\Auth;
class VerificarUsuarioCorrectoMiddleware{
  private $app = null;

  public function __construct($app){
    $this->app = $app;
  }
  public function __invoke ($request, $response, $next){
    $c = $this->app->getContainer();
    $app_token_name = $c->settings['app_token_name'];
    $token = $request->getHeader($app_token_name);

    $route = $request->getAttribute('route');
    $usuario_id_actual = $route->getArgument('usuarioid');

    //var_dump($c->environment);
    if (isset($token[0])) $token = $token[0];
    $usuario_id_token = Auth::GetData($token)->id;
    if($usuario_id_token != $usuario_id_actual){
      return $response->withStatus(401)
                      ->write('No Autorizado');
    }
    return $next($request, $response);
  }
}
?>

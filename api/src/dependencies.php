<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

///Database
$container['db'] =function ($conn){
  $connectionString = $conn->get('settings')['connectionString'];

  $pdo = new PDO($connectionString['dns'], $connectionString['user'], $connectionString['pass']);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  return new FluentPDO($pdo);
};
//models
$container['model']=function($conn){
  return (object)[
    'test' => new App\Model\TestModel($conn->db),
    'usuario' => new App\Model\UsuarioModel($conn->db),
    'auth' => new App\Model\AuthModel($conn->db),
    'producto' => new App\Model\ProductoModel($conn->db),
    'subir' => new App\Model\SubirModel($conn->db)
  ];
};

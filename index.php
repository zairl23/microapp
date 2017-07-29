<?php

use Zend\Diactoros\Response;
use Zend\Diactoros\Server;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\NoopFinalHandler;
use Neychang\Microapp\Http\Middlewares\DispatchRoute;
use Neychang\Microapp\Http\RouteCollection;

require __DIR__ . '/vendor/autoload.php';

$app = new MiddlewarePipe();
$app->setResponsePrototype(new Response());

$server = Server::createServer($app, $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$routes = new RouteCollection();
$routes->addRoute('GET', '/', 'home', function($req, $params, $res){
    $res->getBody()->write('Hello world!');
    return $res;
});
$routes->addRoute('GET', '/test', 'test', function($req, $params, $res){
    $res->getBody()->write('Hello test!');
    return $res;
});

$app->pipe('/', new DispatchRoute($routes));

$server->listen(new NoopFinalHandler());

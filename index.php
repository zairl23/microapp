<?php 

require_once "vendor/autoload.php";

use \Toro;
use Neychang\Microapp\App;

$app = new App();

$routes = require_once __DIR__ . "/src/Config/routes.php";

$handers = require_once __DIR__ . "/src/Config/handlers.php";

$subscribers = require_once __DIR__ . "/src/Config/subscribers.php";

$app->run($handers, $subscribers);


Toro::serve($routes);




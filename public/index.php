<?php
require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/error.php';

$container = ErrorController::handleNotFoundError(new \Slim\Container());

// Create and configure Slim app
$app = new \Slim\App($container, ['settings' => [
  'addContentLengthHeader' => true,
  'displayErrorDetails' => true
]]);

// provide minial default data as db
// also init the app with the api endpoints
API_Routes::init($app);

// Run app
$app->run();
?>

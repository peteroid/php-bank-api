<?php
require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/db.php';
require __DIR__ . '/api.php';

$apiEndpointPrefix = '/api';

$container = new \Slim\Container(); //Create Your container

require __DIR__ . '/error.php';

// Create and configure Slim app
$app = new \Slim\App($container, ['settings' => [
  'addContentLengthHeader' => true,
]]);

// provide minial default data as db
// also init the app with the api endpoints
API::init($app, new MockDB());

// Run app
$app->run();

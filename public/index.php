<?php
require __DIR__ . '/../vendor/autoload.php';

// Create and configure Slim app
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);

// Define app routes
$app->get('/{name}', function ($request, $response, $args) {
    return $response->withJson(array(
      'name' => $args['name']
    ));
});

// Run app
$app->run();

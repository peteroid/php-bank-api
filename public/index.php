<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/db.php';

// Create and configure Slim app
$app = new \Slim\App(['settings' => [
  'addContentLengthHeader' => true,
]]);

// provide minial default data as db
$db = new MockDB();

// open account
$app->post('/{accountId}/open', function ($request, $response, $args) use ($db) {
  $dbResponse = $db->open($args['accountId']);
  return $response->withJson($dbResponse);
});

// close account
$app->post('/{accountId}/close', function ($request, $response, $args) use ($db) {
  $dbResponse = $db->close($args['accountId']);
  return $response->withJson($dbResponse);
});

// TODO
// get balance
$app->get('/{accountId}/balance', function ($request, $response, $args) use ($db) {});

// TODO
// withdraw and deposit money
$app->post('/{accountId}/balance', function ($request, $response, $args) use ($db) {});

// Run app
$app->run();

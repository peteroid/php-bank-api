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
$app->get('/{accountId}/open', function ($request, $response, $args) use ($db) {
  $dbResponse = $db->open($args['accountId']);
  return $response->withJson($dbResponse);
});

// // close account
// $app->get('/{accountId}/open', function ($request, $response, $args) use ($db) {
//   $dbResponse = $db->open($args['accountId']);
//   return $response->withJson($dbResponse);
// });

// Run app
$app->run();

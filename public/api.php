<?php

class API {
  public static function init($app, $db) {
    $app->group('/api', function () use ($app, $db) {
      // open account
      $app->post('/account/{accountId}/open', function ($request, $response, $args) use ($db) {
        $dbResponse = $db->open($args['accountId']);
        return $response->withJson($dbResponse);
      });

      // close account
      $app->post('/account/{accountId}/close', function ($request, $response, $args) use ($db) {
        $dbResponse = $db->close($args['accountId']);
        return $response->withJson($dbResponse);
      });

      // TODO
      // get balance
      $app->get('/{accountId}/balance', function ($request, $response, $args) use ($db) {});

      // TODO
      // withdraw and deposit money
      $app->post('/{accountId}/balance', function ($request, $response, $args) use ($db) {});
    })->add(function ($request, $response, $next) {
      error_log($response);
      $response = $next($request, $response);
      return $response;
    });
  }
}

?>

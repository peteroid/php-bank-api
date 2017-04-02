<?php

require __DIR__ . '/api.php';

class API_Routes {

  public static function init(&$app, $willSaveDB = true) {
    $apiController = new API_Controller($willSaveDB);

    $app->group('/api', function () use (&$app, $apiController) {
      // open account
      $app->post('/account/{accountId}/open', array($apiController, 'openAction'));

      // close account
      $app->post('/account/{accountId}/close', array($apiController, 'closeAction'));

      // TODO
      // get balance
      $app->get('/{accountId}/balance', array($apiController, 'someAction'));

      // TODO
      // withdraw and deposit money
      $app->post('/{accountId}/balance', array($apiController, 'someAction'));
    })->add(function ($request, $response, $next) {
      // error_log($response);
      $response = $next($request, $response);
      return $response;
    });
  }
}

?>

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

      // get balance
      $app->get('/account/{accountId}/balance', array($apiController, 'getBalanceAction'));

      // withdraw and deposit money
      $app->post('/account/{accountId}/deposit/{amount}', array($apiController, 'depositAction'));
      $app->post('/account/{accountId}/withdraw/{amount}', array($apiController, 'withdrawAction'));
    })->add(function ($request, $response, $next) {
      // add any middleware for later development, e.g. auth
      $response = $next($request, $response);
      return $response;
    });
  }
}

?>

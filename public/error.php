<?php

// special handle for api not found
$container['notFoundHandler'] = function ($c) use ($apiEndpointPrefix) {
  return function ($request, $response) use ($c, $apiEndpointPrefix) {
    $isApiReq = substr($request->getUri()->getPath(), 0, strlen($apiEndpointPrefix)) === $apiEndpointPrefix;
    return $isApiReq ?
      $c['response']
        ->withStatus(404)
        ->withJson(array(
          'message' => 'Endpoint not found'
        )) :
      $c['response']
        ->withStatus(404)
        ->withHeader('Content-Type', 'text/html')
        ->write('Page not found');
    };
};

?>

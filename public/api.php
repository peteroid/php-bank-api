<?php

require __DIR__ . '/db.php';

class API_Controller {

  protected $db;

  public function __construct ($willSaveDB = true) {
    $this->db = new MockDB($willSaveDB);
  }

  public function openAction ($request, $response, $args) {
    $dbResponse = $this->db->open($args['accountId']);
    return $response->withJson($dbResponse);
  }

  public function closeAction ($request, $response, $args) {
    $dbResponse = $this->db->close($args['accountId']);
    return $response->withJson($dbResponse);
  }

  public function getBalanceAction ($request, $response, $args) {
    $dbResponse = $this->db->getBalance($args['accountId']);
    return $response->withJson($dbResponse);
  }

  public function depositAction ($request, $response, $args) {
    $dbResponse = $this->db->deposit($args['accountId'], (int) $args['amount']);
    return $response->withJson($dbResponse);
  }

  public function withdrawAction ($request, $response, $args) {
    $dbResponse = $this->db->withdraw($args['accountId'], (int) $args['amount']);
    return $response->withJson($dbResponse);
  }
}

?>

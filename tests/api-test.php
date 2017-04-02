<?php
require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../public/routes.php';

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {

  protected $app;
  protected $testId = '_unit_test_not_exist_id';

  /**
   * @before
   */
  public function setupApi() {
    $this->app = new \Slim\App();
    API_Routes::init($this->app);
  }

  protected function makeRequest ($params) {
    // Prepare a mock environment
    $env = \Slim\Http\Environment::mock($params);
    return \Slim\Http\Request::createFromEnvironment($env);
  }

  // get a json output from the controller
  protected function makeJsonResponse ($params) {
    $request = $this->makeRequest($params);
    $resOut = $this->app->process($request, new \Slim\Http\Response());
    return json_decode((string)$resOut->getBody());
  }

  public function testOpen() {
    $accountId = $this->testId;
    $params = array(
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/account/' . $accountId . '/open'
    );
    $jsonOut = $this->makeJsonResponse($params);
    if (property_exists($jsonOut, 'message')) {
      $this->assertEquals('Account already exists', $jsonOut->message);
      $this->assertEquals(false, $jsonOut->opened);
    } else {
      $this->assertEquals(true, $jsonOut->opened);
      $this->assertEquals(0, $jsonOut->account->balance);
    }

    // open twice much be existed
    $jsonOut = $this->makeJsonResponse($params);
    $this->assertEquals('Account already exists', $jsonOut->message);
    $this->assertEquals(false, $jsonOut->opened);
  }

  /**
   * @depends testOpen
   */
  public function testGetBalanceAfterOpen() {
    $accountId = $this->testId;
    $jsonOut = $this->makeJsonResponse(array(
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/account/' . $accountId . '/balance'
    ));

    $this->assertInternalType('int', $jsonOut->balance);
  }

  /**
   * @depends testOpen
   */
  public function testDepositAfterOpen() {
    $accountId = $this->testId;
    $balanceParams = array(
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/account/' . $accountId . '/balance'
    );
    $balanceJsonOut = $this->makeJsonResponse($balanceParams);
    $currentBalance = $balanceJsonOut->balance;

    $amount = 777;
    $depositJsonOut = $this->makeJsonResponse(array(
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/account/' . $accountId . '/deposit/' . $amount
    ));
    $this->assertEquals(true, $depositJsonOut->success);

    $balanceJsonOut = $this->makeJsonResponse($balanceParams);
    $this->assertEquals($currentBalance + $amount, $balanceJsonOut->balance);
  }

  /**
   * @depends testDepositAfterOpen
   */
  public function testClose() {
    $accountId = $this->testId;
    $params = array(
        'REQUEST_METHOD' => 'POST',
        'REQUEST_URI' => '/api/account/' . $accountId . '/close'
    );
    $jsonOut = $this->makeJsonResponse($params);

    if (property_exists($jsonOut, 'message')) {
      $this->assertEquals('Account doesn\'t exist', $jsonOut->message);
      $this->assertEquals(false, $jsonOut->deleted);
    } else {
      $this->assertEquals(true, $jsonOut->deleted);
    }

    // close twice much be missed
    $jsonOut = $this->makeJsonResponse($params);
    $this->assertEquals('Account doesn\'t exist', $jsonOut->message);
    $this->assertEquals(false, $jsonOut->deleted);
  }

  /**
   * @depends testClose
   */
  public function testGetBalanceAfterClose() {
    $accountId = $this->testId;
    $jsonOut = $this->makeJsonResponse(array(
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/api/account/' . $accountId . '/balance'
    ));

    $this->assertEquals('Account doesn\'t exist', $jsonOut->message);
    $this->assertEquals(-1, $jsonOut->balance);
  }
}

?>

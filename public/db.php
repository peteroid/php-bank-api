<?php

class MockDB {
  var $filename = __DIR__ . '/db.store';
  var $message = '';

  /**
   * Simulate db open action
   * Create an account by account id with the params
   * and store the account
   * @param $accountId : string
   * @param $param - other account details : array
   */
  public function open($accountId, $param = []) {
    $account = null;
    $opened = false;
    $this->withStore(function (&$accounts) use ($accountId, $param, &$account, &$opened) {
      if (!array_key_exists($accountId, $accounts)) {
        $accounts[$accountId] = array_merge($param, array(
          'balance' => 0,
          'created_date' => time()
        ));
        $opened = true;
      } else {
        $this->message = "Account already exists";
      }

      $account = $accounts[$accountId];
    });

    return $this->withMessage(array_merge(array(
      'opened' => $opened,
    ), $opened ? array(
      'account' => $account
    ) : array()));
  }

  /** db close action
   * Delete an account by account id from the store
   * @param $accountId : string
   */
  public function close($accountId) {
    $deleted = false;
    $this->withStore(function (&$accounts) use ($accountId, &$deleted) {
      if (array_key_exists($accountId, $accounts)) {
        unset($accounts[$accountId]);
        $deleted = !array_key_exists($accountId, $accounts);
      } else {
        $this->message = "Account doesn't exist";
      }
    });

    return $this->withMessage(array(
      'deleted' => $deleted
    ));
  }

  // wrapper for getting the store and then store it back after action
  // this is just a simple json store, not using for real production usage
  private function withStore($cb) {
    // retrive the store
    $accounts = json_decode(file_get_contents($this->filename), true);
    if ($accounts === false || $accounts === null) {
      $accounts = array(
        'created_date' => time()
      );
    }

    call_user_func_array($cb, array(&$accounts));

    // save the store
    file_put_contents($this->filename, json_encode($accounts));
    // error_log(json_encode($accounts));
  }

  private function withMessage($responseParam) {
    return ($this->message !== '') ? array_merge($responseParam, array(
      'message' => $this->message
    )) : $responseParam;
  }
}

?>

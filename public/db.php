<?php

class MockDB {
  var $filename = __DIR__ . '/db.store';

  // simulate db open action
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
      }

      $account = $accounts[$accountId];
      return $accounts;
    });

    return array(
      'opened' => $opened,
      'account' => $account
    );
  }

  // wrapper for getting the store and then store it back after action
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
}

?>

## API demo

### Features
- simple bank services
- no user auth
- raw json as the data store
- based on [Slim](www.slimframework.com) framework

### Tested Environment
- macOS Sierra 10.12.3
- php 7.0.17
- composer 1.4.1

### Run on your own
1. clone this repo
2. `cd php-bank-api`
3. `composer install`
4. run the app locally, or
  ```
  php -S localhost:8888 -t public public/index.php

  # run this in bash
  curl -X POST localhost:8888/account/my_account/open
  ```
5. run the unit test
  ```
  ./vendor/bin/phpunit tests/api-test.php
  ```

### Services
- Open account
  - `POST /api/account/{accountId}/open`
- Close account
  - `POST /api/account/{accountId}/close`
- Get current balance
  - `GET /api/account/{accountId}/balance`
- Deposit money
  - `POST /api/account/{accountId}/deposit/{amount}`
- Withdraw money
  - `POST /api/account/{accountId}/withdraw/{amount}`

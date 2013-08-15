bitmessage-php
==============

Bitmessage-php is a backend library to communicate with an installed [Bitmessage][1] client.

In this context the installed Bitmessage client is the server where the communication passed.

Bitmessage-Api features to communicate with the client gui directly are not inclueded. Its a server side library.


Installation
------------

You can install bitmessage-php using composer

```json
"require": {
    "username/bitmessage-php": "dev-master"
}
```

or just typing `composer require username/bitmessage-php`


Usage
-----

**Example: Hello World**

```php
$bmc = new Bitmessage\BitmessageClient('localhost', 8442, 'testUser', 'testPw');
echo $bmc->test('helloWorld', 'Hello', 'World');
Hello-World
```

**Example: Create Random Address**

```php
$bmc = new Bitmessage\BitmessageClient('localhost', 8442, 'testUser', 'testPw');
echo $bmc->createRandomAddress('Test-Label');
BM-2D7QKHUhFGd7SKwtVSzawWpB3Mmw5j8BNw
```

**Example: Send message**

```php
$bmc = new Bitmessage\BitmessageClient('localhost', 8442, 'testUser', 'testPw');
echo $bmc->sendMessage('to-address', 'from-address', 'subject', 'message');
b3ce1c0308eb0765e0c67eeaf851fc8d0d752359c8f1e499d1fe02e39affbc67
```

***NOTICE***
> The `from-address` have to be present as an identity in the bitmessage client.


Testing
-------

You can run all unit tests at once by executing `phpunit` in the root directory.

`~/bitmessage-php $ phpunit`


[1]: https://bitmessage.org/wiki/Main_Page

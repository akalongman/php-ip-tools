# PHP IP Tools

[![Join the chat at
https://gitter.im/akalongman/php-ip-tools](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/akalongman/php-ip-tools?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/akalongman/php-ip-tools.svg?branch=master)](https://travis-ci.org/akalongman/php-ip-tools)
[![Latest Stable
Version](https://img.shields.io/packagist/v/Longman/ip-tools.svg)](https://packagist.org/packages/longman/ip-tools)
[![Total Downloads](https://img.shields.io/packagist/dt/Longman/ip-tools.svg)](https://packagist.org/packages/longman/ip-tools)
[![Downloads Month](https://img.shields.io/packagist/dm/Longman/ip-tools.svg)](https://packagist.org/packages/longman/ip-tools)
[![License](https://img.shields.io/packagist/l/Longman/ip-tools.svg)](https://packagist.org/packages/longman/ip-tools)


IP Tools for manipulation on IP's.

### Require this package with Composer
Install this package through [Composer](https://getcomposer.org/).
Edit your project's `composer.json` file to require
`longman/ip-tools`.

Create *composer.json* file:
```js
{
    "name": "yourproject/yourproject",
    "type": "project",
    "require": {
        "php": ">=5.3.0",
        "longman/ip-tools": "~1.0.1"
    }
}
```
And run composer update

**Or** run a command in your command line:

```
composer require longman/ip-tools
```

### Usage
```php
<?php
$loader = require __DIR__.'/vendor/autoload.php';

use Longman\IPTools\Ip;

// Validating
$status = Ip::isValid('192.168.1.1'); // true

$status = Ip::isValid('192.168.1.256'); // false


// Matching

$status = Ip::match('192.168.1.1', '192.168.1.*'); // true

$status = Ip::match('192.168.1.1', '192.168.*.*'); // true

$status = Ip::match('192.168.1.1', '192.168.*.*'); // true

$status = Ip::match('192.168.1.1', '192.168.1/24'); // true

$status = Ip::match('192.168.1.1', '192.168.1.1/255.255.255.0'); // true

$status = Ip::match('192.168.1.1', array('122.128.123.123', '192.168.1.*', '192.168.123.124')); // true


$status = Ip::match('192.168.1.1', '192.168.0.*'); // false

$status = Ip::match('192.168.1.1', '192.168.0/24'); // false

$status = Ip::match('192.168.1.1', '192.168.0.0/255.255.255.0'); // false

$status = Ip::match('192.168.1.1', array('192.168.123.*', '192.168.123.124'));

```




-----
This code is available on
[Github](https://github.com/akalongman/php-ip-tools). Pull requests are welcome.

## Troubleshooting
If you like living on the edge, please report any bugs you find on the
[PHP IP Tools issues](https://github.com/akalongman/php-ip-tools/issues) page.
## Contributing
See [CONTRIBUTING.md](CONTRIBUTING.md) for information.
## Credits

Credit list in [CREDITS](CREDITS)

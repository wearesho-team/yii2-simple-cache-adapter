# Yii2 SimpleCache adapter
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/yii2-simple-cache-adapter/version)](https://packagist.org/packages/wearesho-team/yii2-simple-cache-adapter)
[![Total Downloads](https://poser.pugx.org/wearesho-team/yii2-simple-cache-adapter/downloads)](https://packagist.org/packages/wearesho-team/yii2-simple-cache-adapter)
[![Test & Lint](https://github.com/wearesho-team/yii2-simple-cache-adapter/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/wearesho-team/yii2-simple-cache-adapter/actions/workflows/php.yml)
[![codecov](https://codecov.io/gh/wearesho-team/yii2-simple-cache-adapter/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/yii2-simple-cache-adapter)

An Adapter for SimpleCache (PSR-16) to Yii2 cache

This library originally developed by [devonliu02](https://github.com/devonliu02),
now maintained by [Wearesho Team](https://wearesho.com)

## Requirements
- PHP >=8.4 (tested on PHP 8.4, PHP 8.5)
- [psr/simple-cache](https://github.com/php-fig/simple-cache) 3

## Installation

```bash
composer require wearesho-team/yii2-simple-cache-adapter:^2.0
```

## Usage

```php
<?php

use Wearesho\SimpleCache;

$adapter = new SimpleCache\Adapter; // will use \Yii::$app->cache by default

$customAdapter = new SimpleCache\Adapter([
    'cache' => [
        'class' => \yii\caching\ArrayCache::class, // or your custom \yii\caching\CacheInterface implementation
    ],
]);

```

## Contributors
- [Alexander Letnikow](mailto:reclamme@gmail.com)
- [devonliu02](https://github.com/devonliu02)

## License
[MIT](./LICENSE.md)

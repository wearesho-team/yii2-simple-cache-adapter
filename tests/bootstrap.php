<?php

// phpcs:ignoreFile

define('YII_DEBUG', true);

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

\Yii::setAlias('@runtime', __DIR__ . './output');

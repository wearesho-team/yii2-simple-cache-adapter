<?php

namespace Wearesho\SimpleCache\Tests;

use Cache\IntegrationTests\SimpleCacheTest;
use Wearesho\SimpleCache;
use yii\caching;

/**
 * Class SimpleCacheAdapterWithFileTest
 * @package Wearesho\SimpleCache\Tests
 */
class SimpleCacheAdapterWithFileTest extends SimpleCacheTest
{
    protected $skippedTests = [
        'testSetMultipleWithIntegerArrayKey' => '',
    ];

    public function createSimpleCache()
    {
        return new SimpleCache\Adapter([
            'cache' => [
                'class' => caching\FileCache::class,
            ],
        ]);
    }
}

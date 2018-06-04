<?php

namespace Wearesho\SimpleCache\Tests;

use Cache\IntegrationTests\SimpleCacheTest;
use Wearesho\SimpleCache;
use yii\caching;

/**
 * Class SimpleCacheAdapterWithMemoryTest
 * @package Wearesho\SimpleCache\Tests
 */
class SimpleCacheAdapterWithMemoryTest extends SimpleCacheTest
{
    protected $skippedTests = [
        'testSetMultipleWithIntegerArrayKey' => '',
    ];

    public function createSimpleCache()
    {
        return new SimpleCache\Adapter([
            'cache' => [
                'class' => caching\ArrayCache::class,
            ],
        ]);
    }
}

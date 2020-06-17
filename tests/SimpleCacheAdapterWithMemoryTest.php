<?php

namespace Wearesho\SimpleCache\Tests;

use Psr\SimpleCache\CacheInterface;
use Wearesho\SimpleCache;
use yii\caching;

class SimpleCacheAdapterWithMemoryTest extends SimpleCacheTest
{
    protected array $skippedTests = [
        'testSetMultipleWithIntegerArrayKey' => '',
    ];

    protected function createSimpleCache(): CacheInterface
    {
        return new SimpleCache\Adapter([
            'cache' => [
                'class' => caching\ArrayCache::class,
            ],
        ]);
    }
}

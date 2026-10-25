<?php

declare(strict_types=1);

namespace Wearesho\SimpleCache\Tests;

use Cache\IntegrationTests\SimpleCacheTest;
use Psr\SimpleCache\CacheInterface;
use Wearesho\SimpleCache;
use yii\caching;

class SimpleCacheAdapterWithMemoryTest extends SimpleCacheTest
{
    protected array $skippedTests = [
        'testSetMultipleWithIntegerArrayKey' => '',
    ];

    public function createSimpleCache(): CacheInterface
    {
        return new SimpleCache\Adapter([
            'cache' => [
                'class' => caching\ArrayCache::class,
            ],
        ]);
    }
}

<?php declare(strict_types=1);

namespace Wearesho\SimpleCache;

use Psr\SimpleCache\CacheInterface;
use yii\base;

class Bootstrap implements base\BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->setContainer([
            'singletons' => [
                CacheInterface::class => Adapter::class,
            ],
        ]);
    }
}

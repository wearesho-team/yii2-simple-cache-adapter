<?php declare(strict_types=1);

namespace Wearesho\SimpleCache;

use yii\base;
use yii\caching;
use yii\di;
use Psr\SimpleCache;

/**
 * Class Adapter
 * @package Wearesho\SimpleCache
 */
class Adapter extends base\Component implements SimpleCache\CacheInterface
{
    public const INVALID_KEY_CHARACTER = '{}()/\@:';

    /**
     * @var caching\CacheInterface|array|string definition
     */
    public $cache = 'cache';

    /**
     * @throws base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        $this->cache = di\Instance::ensure($this->cache, caching\CacheInterface::class);
    }

    /**
     * Cache::get() return false if the value is not in the cache or expired, but PSR-16 return $default(null)
     *
     * @throws InvalidArgumentException
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->assertValidKey($key);

        $data = $this->cache->get($key);

        if ($data === false) {
            return $default;
        } else {
            if ($data === null) {
                return false;
            } else {
                return $data;
            }
        }
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $this->assertValidKey($key);

        if (($duration = $this->toSeconds($ttl)) === false) {
            return $this->delete($key);
        }

        if ($value === null) {
            return $this->delete($key);
        }

        // case FALSE to null so we can detect that if
        // the cache miss/expired or it did set the FALSE value into cache
        $value = $value == false ? null : $value;
        return $this->cache->set($key, $value, $duration);
    }

    public function delete(string $key): bool
    {
        $this->assertValidKey($key);

        return $this->has($key) ? $this->cache->delete($key) : true;
    }

    public function clear(): bool
    {
        return $this->cache->flush();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $pairs = [];
        foreach ($keys as $key) {
            $this->assertValidKey($key);
            $pairs[] = [$key, $this->get($key, $default)];
        }

        // yield instead of returning an array: array keys would cast numeric strings (e.g. '123') to int
        return (static function () use ($pairs): \Generator {
            foreach ($pairs as [$key, $value]) {
                yield $key => $value;
            }
        })();
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        $pairs = [];
        foreach ($values as $key => $value) {
            $this->assertValidKey($key);
            $pairs[$key] = $value;
        }

        $res = true;
        foreach ($pairs as $key => $value) {
            $res = $res && $this->set($key, $value, $ttl);
        }

        return $res;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        if (!is_array($keys)) {
            $keys = iterator_to_array($keys, false);
        }

        foreach ($keys as $key) {
            $this->assertValidKey($key);
        }

        $res = true;
        array_map(function ($key) use (&$res) {
            $res = $res && $this->delete($key);
        }, $keys);

        return $res;
    }

    public function has(string $key): bool
    {
        $this->assertValidKey($key);

        return $this->cache->exists($key);
    }

    /**
     * @param $key
     * @throws InvalidArgumentException
     */
    protected function assertValidKey($key)
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException('Invalid key: ' . var_export($key, true) . '. Key should be a string.');
        }

        if ($key === '') {
            throw new InvalidArgumentException('Invalid key. Key should not be empty.');
        }

        // valid key according to PSR-16 rules
        $invalid = preg_quote(static::INVALID_KEY_CHARACTER, '/');
        if (preg_match('/[' . $invalid . ']/', $key)) {
            throw new InvalidArgumentException(
                'Invalid key: ' . $key . '. Contains (a) character(s) reserved ' .
                'for future extension: ' . static::INVALID_KEY_CHARACTER
            );
        }
    }

    /**
     * @param $ttl
     * @throws InvalidArgumentException
     */
    protected function assertValidTtl($ttl)
    {
        if ($ttl !== null && !is_int($ttl) && !$ttl instanceof \DateInterval) {
            $error = 'Invalid time: ' . serialize($ttl) . '. Must be integer or instance of DateInterval.';
            throw new InvalidArgumentException($error);
        }
    }

    /**
     * @param $ttl
     * @return false|int
     * @throws InvalidArgumentException
     */
    protected function toSeconds($ttl)
    {
        $this->assertValidTtl($ttl);

        if ($ttl === null) {
            // 0 means forever in Yii 2 cache
            return 0;
        }

        if (is_int($ttl)) {
            $sec = $ttl;
        } else {
            $sec = ((new \DateTime())->add($ttl))->getTimestamp() - (new \DateTime())->getTimestamp();
        }

        return $sec > 0 ? $sec : false;
    }
}

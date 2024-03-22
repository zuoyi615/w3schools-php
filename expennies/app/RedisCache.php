<?php

declare(strict_types=1);

namespace App;

use DateInterval;
use DateTime;
use Psr\SimpleCache\CacheInterface;
use Redis;
use RedisException;

readonly class RedisCache implements CacheInterface
{

    public function __construct(private Redis $redis) {}

    /**
     * @throws RedisException
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->redis->get($key);

        return $value === false ? $default : $value;
    }

    /**
     * @throws RedisException
     */
    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        if ($ttl instanceof DateInterval) {
            $ttl = (new DateTime('@0'))->add($ttl)->getTimestamp();
        }

        return $this->redis->set($key, $value, $ttl);
    }

    /**
     * @throws RedisException
     */
    public function delete(string $key): bool
    {
        return $this->redis->del($key) === 1;
    }

    /**
     * @throws RedisException
     */
    public function clear(): bool
    {
        return $this->redis->flushDB();
    }

    /**
     * @throws RedisException
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = $this->redis->mGet((array) $keys);
        $result = [];

        foreach ($values as $i => $value) {
            $result[$keys[$i]] = $value === false ? $default : $value;
        }

        return $result;
    }

    /**
     * @throws RedisException
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        $values = (array) $values;
        $result = $this->redis->mSet($values);

        if ($ttl instanceof DateInterval) {
            $ttl = (new DateTime('@0'))->add($ttl)->getTimestamp();
            foreach (array_keys($values) as $key) {
                $this->redis->expire($key, $ttl);
            }
        }

        return $result;
    }

    /**
     * @throws RedisException
     */
    public function deleteMultiple(iterable $keys): bool
    {
        $keys = (array) $keys;

        return $this->redis->del($keys) === count($keys);
    }

    /**
     * @throws RedisException
     */
    public function has(string $key): bool
    {
        return $this->redis->exists($key);
    }

}

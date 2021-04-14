<?php
declare(strict_types = 1);

namespace App\Services\Cache;

use Closure;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Utils\ApplicationContext;

class CacheService
{
    public static function getInstance()
    {
        return ApplicationContext::getContainer()->get(CacheInterface::class);
    }

    public static function remember($key, $ttl, Closure $callback)
    {
        $instance = self::getInstance();

        $value = $instance->get($key);

        if ( !is_null($value)) {
            return $value;
        }

        $instance->set($key, $value = $callback(), $ttl);

        return $value;
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->$name(...$arguments);
    }
}

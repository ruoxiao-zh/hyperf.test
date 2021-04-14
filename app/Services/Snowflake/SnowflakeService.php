<?php
declare(strict_types = 1);

namespace App\Services\Snowflake;

use Hyperf\Snowflake\Meta;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Snowflake\IdGeneratorInterface;

class SnowflakeService
{
    public static function getInstance()
    {
        return ApplicationContext::getContainer()->get(IdGeneratorInterface::class);
    }

    public static function generate(): int
    {
        return self::getInstance()->generate();
    }

    public static function degenerate(int $id): Meta
    {
        return self::getInstance()->degenerate($id);
    }
}

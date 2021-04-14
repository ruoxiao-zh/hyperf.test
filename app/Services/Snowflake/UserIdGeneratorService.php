<?php
declare(strict_types = 1);

namespace App\Services\Snowflake;

use Hyperf\Snowflake\Meta;
use Hyperf\Snowflake\IdGenerator;
use Hyperf\Snowflake\IdGenerator\SnowflakeIdGenerator;

class UserIdGeneratorService
{
    /**
     * @var IdGenerator\SnowflakeIdGenerator
     */
    protected $idGenerator;

    public function __construct(SnowflakeIdGenerator $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }

    public function generate(int $userId): int
    {
        $meta = $this->idGenerator->getMetaGenerator()->generate();

        return $this->idGenerator->generate($meta->setWorkerId($userId % 31));
    }

    public function degenerate(int $id): Meta
    {
        return $this->idGenerator->degenerate($id);
    }
}
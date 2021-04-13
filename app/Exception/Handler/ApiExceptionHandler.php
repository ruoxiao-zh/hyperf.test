<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Throwable;
use App\Constants\HttpCodeEnum;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     * @Inject
     */
    protected $logger;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());

        $this->stopPropagation();

        if ($throwable instanceof ModelNotFoundException) {
            $data = json_encode(['message' => '404 Not Found!'], JSON_UNESCAPED_UNICODE);

            return $response->withStatus(HttpCodeEnum::HTTP_CODE_404)->withBody(new SwooleStream($data));
        }

        if ($throwable instanceof ValidationException) {
            $data = json_encode(['message' => $throwable->validator->errors()->first()], JSON_UNESCAPED_UNICODE);

            return $response->withStatus($throwable->status)->withBody(new SwooleStream($data));
        }

        if ($throwable instanceof HttpException) {
            $data = json_encode(['message' => $throwable->getMessage()], JSON_UNESCAPED_UNICODE);

            return $response->withStatus($throwable->getStatusCode())->withBody(new SwooleStream($data));
        }

        return $response->withHeader('Server', 'Hyperf')->withStatus(500)->withBody(new SwooleStream('Internal Server Error.'));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}

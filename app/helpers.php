<?php

declare (strict_types = 1);

use App\Constants\HttpCodeEnum;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

if ( !function_exists('response')) {

    /**
     * Return a new response from the application.
     *
     * @param string|array|null $content
     * @param int $statusCode
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    function response(ResponseInterface $response, $content = [], int $statusCode = HttpCodeEnum::HTTP_CODE_200): Psr7ResponseInterface
    {
        if (is_null($content)) {
            return $response->withStatus($statusCode);
        }

        return $response->json($content)->withStatus($statusCode);
    }
}

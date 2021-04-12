<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\Slideshow;
use App\Resource\SlideshowResource;
use App\Controller\AbstractController;
use Hyperf\Resource\Json\JsonResource;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller(prefix="api")
 *
 * Class SlideshowsController
 */
class SlideshowsController extends AbstractController
{
    /**
     * @RequestMapping(path="slideshows", methods={"get"})
     *
     */
    public function index(RequestInterface $request): JsonResource
    {
        return SlideshowResource::collection(Slideshow::query()->sorted()->recent()->paginate());
    }
}

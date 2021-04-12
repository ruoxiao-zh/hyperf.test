<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Model\Product;
use App\Resource\ProductResource;
use Hyperf\Resource\Json\JsonResource;
use App\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller(prefix="api")v
 *
 * Class ProductsController
 */
class ProductsController extends AbstractController
{
    /**
     * @RequestMapping(path="products", methods={"get"})
     */
    public function index(RequestInterface $request): JsonResource
    {
        return ProductResource::collection(Product::query()->onSale()->recent()->paginate());
    }
}
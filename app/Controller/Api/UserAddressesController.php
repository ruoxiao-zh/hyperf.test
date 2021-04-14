<?php
declare(strict_types = 1);

namespace App\Controller\Api;

use App\Model\UserAddress;
use App\Constants\HttpCodeEnum;
use App\Services\Cache\CacheService;
use Hyperf\Di\Annotation\Inject;
use App\Resource\UserAddressResource;
use Hyperf\Cache\Annotation\Cacheable;
use App\Controller\AbstractController;
use Hyperf\Resource\Json\JsonResource;
use App\Request\Api\UserAddressRequest;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use App\Services\UserAddress\UserAddressService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as ResponseContract;

/**
 * @Controller(prefix="api")
 *
 * Class UserAddressesController
 */
class UserAddressesController extends AbstractController
{
    /**
     * @Inject
     * @var UserAddressService
     */
    protected $userAddressService;

    /**
     * @RequestMapping(path="user_addresses", methods={"get"})
     *
     * @param RequestInterface $request
     * @return JsonResource
     */
    public function index(RequestInterface $request): JsonResource
    {
        return UserAddressResource::collection($this->userAddressService->getAll($request));
    }

    /**
     * @RequestMapping(path="user_addresses", methods={"post"})
     *
     * @param UserAddressRequest $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function store(UserAddressRequest $request): ResponseInterface
    {
        $data = array_merge($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]), ['user_id' => random_int(1, 999)]);

        $userAddress = UserAddress::create($data);

        return (new UserAddressResource($userAddress))->toResponse()->withStatus(HttpCodeEnum::HTTP_CODE_201);
    }

    /**
     * @RequestMapping(path="user_addresses/{id:\d+}", methods={"get"})
     *
     * @param RequestInterface $request
     * @return JsonResource
     */
    public function show(RequestInterface $request): JsonResource
    {
        return new UserAddressResource(UserAddress::findFromCache($request->route('id')));
    }

    /**
     *@RequestMapping(path="user_addresses/{id:\d+}", methods={"put"})
     *
     * @param UserAddressRequest $request
     * @param UserAddress $userAddress
     * @return JsonResource
     */
    public function update(UserAddressRequest $request, UserAddress $userAddress): JsonResource
    {
        $this->userAddressService->checkAuthorize($userAddress);

        $userAddress->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return new UserAddressResource($userAddress);
    }

    /**
     * @RequestMapping(path="user_addresses/{id:\d+}", methods={"delete"})
     *
     * @param RequestInterface $request
     * @param ResponseContract $response
     * @return mixed
     */
    public function destroy(RequestInterface $request, ResponseContract $response): Psr7ResponseInterface
    {
        // $this->userAddressService->checkAuthorize($userAddress);

        UserAddress::query(true)->where('id', $request->route('id'))->delete();

        return response($response, null, HttpCodeEnum::HTTP_CODE_204);
    }
}

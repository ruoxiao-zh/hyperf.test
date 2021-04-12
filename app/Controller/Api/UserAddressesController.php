<?php
declare(strict_types = 1);

namespace App\Controller\Api;

use App\Constants\HttpCodeEnum;
use App\Model\UserAddress;
use App\Request\Api\UserAddressRequest;
use App\Resource\UserAddressResource;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;
use Hyperf\Resource\Json\JsonResource;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use App\Services\UserAddress\UserAddressService;
use Hyperf\HttpServer\Contract\RequestInterface;

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
     */
    public function index(RequestInterface $request): JsonResource
    {
        return UserAddressResource::collection(UserAddress::query()->sorted()->recent()->paginate());
    }

    public function store(UserAddressRequest $request): object
    {
        $userAddress = $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return (new UserAddressResource($userAddress))->toResponse()->setStatusCode(HttpCodeEnum::HTTP_CODE_201);
    }

    public function show(UserAddress $userAddress): JsonResource
    {
        return new UserAddressResource($userAddress);
    }

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

    public function destroy(UserAddress $userAddress)
    {
        $this->userAddressService->checkAuthorize($userAddress);

        $userAddress->delete();

        return response(null, HttpCodeEnum::HTTP_CODE_204);
    }
}

<?php
declare(strict_types = 1);

namespace App\Controller\Api;

use App\Model\UserAddress;
use App\Constants\HttpCodeEnum;
use Hyperf\Di\Annotation\Inject;
use App\Resource\UserAddressResource;
use App\Controller\AbstractController;
use Hyperf\Resource\Json\JsonResource;
use App\Request\Api\UserAddressRequest;
use Psr\Http\Message\ResponseInterface;
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
     * @return JsonResource
     */
    public function index(RequestInterface $request): JsonResource
    {
        return UserAddressResource::collection(UserAddress::query()->recent()->paginate());
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

    public function destroy(UserAddress $userAddress)
    {
        $this->userAddressService->checkAuthorize($userAddress);

        $userAddress->delete();

        return response(null, HttpCodeEnum::HTTP_CODE_204);
    }
}

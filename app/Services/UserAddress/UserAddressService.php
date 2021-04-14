<?php
declare(strict_types = 1);

namespace App\Services\UserAddress;

use App\Model\UserAddress;
use App\Services\Cache\CacheService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Listener\DeleteListenerEvent;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class UserAddressService
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @Cacheable(prefix="user_address", value="_#{id}", listener="user_addresses_update")
     */
    public function getCache(int $id): string
    {
        return $id . '_' . uniqid('', true);
    }

    public function flushCache(): bool
    {
        $this->dispatcher->dispatch(new DeleteListenerEvent('user_addresses_update'));

        return true;
    }

    public function getCacheKey(RequestInterface $request): string
    {
        if ($id = $request->route('id')) {
            return UserAddress::getModelName() . '_id_' . $id;
        }

        return UserAddress::getModelName() . '_page_' . $request->input('page', 1);
    }

    public function getAll(RequestInterface $request)
    {
        return CacheService::remember($this->getCacheKey($request), 7200, function () {
            return UserAddress::query()->recent()->paginate();
        });
    }
}

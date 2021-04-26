<?php

namespace Domain\Services\Api;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\EbayServiceContract;

/**
 * Class EbayService
 * @package Domain\Services
 */
class EbayService extends BaseService implements EbayServiceContract
{
    /**
     * TestingService constructor.
     * @param UserRepositoryContract $repo
     */
    public function __construct(UserRepositoryContract $repo)
    {
        parent::__construct($repo);
    }

    /**
     * @return mixed
     */
    public function createInventory()
    {
        /** @var EbayLocationService $ebayLocation */
        $ebayInventoryLocation = app(EbayLocationService::class);
        $resp = $ebayInventoryLocation->createInventoryLocation();

        return $resp;
    }
}

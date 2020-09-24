<?php

namespace Domain\Services;

use Domain\Abstractions\BaseService;
use Domain\Contracts\Repositories\UserRepositoryContract;
use Domain\Contracts\Services\TestingServiceContract;
use Illuminate\Support\Facades\Log;

/**
 * Class TestingService
 * @package Domain\Services
 */
class TestingService extends BaseService implements TestingServiceContract
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
    public function getAllUser()
    {
        /** @var $userRepo UserRepositoryContract */
        $userRepo = $this->getRepo();

        return $userRepo->all();
    }
}

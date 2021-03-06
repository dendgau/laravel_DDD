<?php

namespace Infrastructure\Persistences\Abstractions;

use Infrastructure\Persistences\Contracts\AdvanceRepositoryContract;
use Infrastructure\Persistences\Contracts\BaseRepositoryContract;
use Prettus\Repository\Eloquent\BaseRepository as AbstractionBaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 * @package Infrastructure\Persistences\Abstractions
 */
abstract class BaseRepository extends AbstractionBaseRepository implements BaseRepositoryContract, AdvanceRepositoryContract
{
    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        DB::commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        DB::rollback();
    }
}

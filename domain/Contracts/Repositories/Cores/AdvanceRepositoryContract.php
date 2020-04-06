<?php

namespace Domain\Contracts\Repositories\Cores;

/**
 * Interface AdvanceRepositoryContract
 * @package Domain\Contracts\Repositories\Core
 */
interface AdvanceRepositoryContract
{
    /**
     * Begin transaction
     */
    public function beginTransaction();

    /**
     * Commit transaction
     */
    public function commit();

    /**
     * Rollback transaction
     */
    public function rollback();
}

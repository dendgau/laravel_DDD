<?php

namespace Domain\Abstractions;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package Domain\Abstractions
 */
abstract class BaseEntity extends Model
{
    /**
     * The primary key is non-incrementing
     * @var bool
     */
    public $incrementing = true;
}

<?php

namespace App\Policies;

use App\User;
use Domain\Entities\Eloquents\BlogEntity;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $this->checkIsAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  BlogEntity  $blogEntity
     * @return mixed
     */
    public function view(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAuthor($user, $blogEntity);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  BlogEntity  $blogEntity
     * @return mixed
     */
    public function update(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAuthor($user, $blogEntity);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  BlogEntity  $blogEntity
     * @return mixed
     */
    public function delete(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAuthor($user, $blogEntity);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  BlogEntity  $blogEntity
     * @return mixed
     */
    public function restore(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAuthor($user, $blogEntity);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  BlogEntity  $blogEntity
     * @return mixed
     */
    public function forceDelete(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAuthor($user, $blogEntity);
    }

    /**
     * @param User $user
     * @param BlogEntity $blogEntity
     * @return bool
     */
    private function checkIsAuthor(User $user, BlogEntity $blogEntity)
    {
        return $this->checkIsAdmin($user) && ($user->id == $blogEntity->user_id);
    }

    /**
     * @param User $user
     * @return bool
     */
    private function checkIsAdmin(User $user)
    {
        return ($user->email == 'root@ddd-frontweb-local.com'); // Hard code for super admin
    }
}

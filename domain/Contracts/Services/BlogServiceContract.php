<?php

namespace Domain\Contracts\Services;

/**
 * Interface BlogServiceContract
 * @package Domain\Contracts\Services
 */
interface BlogServiceContract extends BaseServiceContract
{
    /**
     * Play the role as lazy load
     * @return mixed
     */
    public function getListBlogBelongUserByLazyLoad();

    /**
     * Play the role as eager load
     * @return mixed
     */
    public function getListBlogBelongUserByEagerLoad();

    /**
     * @param $id
     * @param $params
     * @return mixed
     */
    public function updateBlogById($id, $params);

    /**
     * Create multi blogs
     * @return array
     */
    public function autoInsertBlog();

    /**
     * Auto create and insert blog and comment
     */
    public function autoInsertBlogComment();
}

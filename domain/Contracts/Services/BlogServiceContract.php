<?php

namespace Domain\Contracts\Services;

use Domain\Entities\Eloquents\BlogEntity;

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
     * @return BlogEntity
     */
    public function getBlog($id);

    /**
     * @param $id
     * @param $params
     * @return bool|mixed
     */
    public function updateBlog($id, $params);

    /**
     * @param $id
     * @return bool|null
     * @throws Exception
     */
    public function deleteBlog($id);

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

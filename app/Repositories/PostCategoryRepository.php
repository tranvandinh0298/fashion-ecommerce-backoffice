<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostCategoryInterface;
use App\Traits\RequestToCoreTrait;

class PostCategoryRepository implements PostCategoryInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllPostCategories($requestData)
    {
        return $this->sendGetRequest($this->url . "/post-categories", $requestData, __METHOD__);
    }
    public function getAllPostCategoriesWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/post-categories/without-pagination", $requestData, __METHOD__);
    }
    public function getPostCategoryById($id)
    {
        return $this->sendGetRequest($this->url . "/post-categories/".$id, [], __METHOD__);
    }
    public function createPostCategory(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/post-categories", $insertData, __METHOD__);
    }
    public function updatePostCategory(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/post-categories/".$id, $updateData, __METHOD__);
    }
    public function softDeletePostCategory(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/post-categories/".$id."/soft-delete", __METHOD__);
    }
    public function deletePostCategory(int $id)
    {
    }
}

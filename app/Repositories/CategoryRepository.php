<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Traits\RequestToCoreTrait;

class CategoryRepository implements CategoryInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllCategories($requestData)
    {
        return $this->sendGetRequest($this->url . "/categories", $requestData, __METHOD__);
    }
    public function getAllCategoriesWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/categories/without-pagination", $requestData, __METHOD__);
    }
    public function getCategoryById($id)
    {
        return $this->sendGetRequest($this->url . "/categories/".$id, [], __METHOD__);
    }
    public function createCategory(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/categories", $insertData, __METHOD__);
    }
    public function updateCategory(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/categories/".$id, $updateData, __METHOD__);
    }
    public function softDeleteCategory(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/categories/".$id."/soft-delete", __METHOD__);
    }
    public function deleteCategory(int $id)
    {
    }
}

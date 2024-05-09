<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductInterface;
use App\Traits\RequestToCoreTrait;

class ProductRepository implements ProductInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllProducts($requestData)
    {
        return $this->sendGetRequest($this->url . "/products", $requestData, __METHOD__);
    }
    public function getAllProductsWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/products/without-pagination", $requestData, __METHOD__);
    }
    public function getProductById($id)
    {
        return $this->sendGetRequest($this->url . "/products/".$id, [], __METHOD__);
    }
    public function createProduct(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/products", $insertData, __METHOD__);
    }
    public function updateProduct(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/products/".$id, $updateData, __METHOD__);
    }
    public function softDeleteProduct(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/products/".$id."/soft-delete", __METHOD__);
    }
    public function deleteProduct(int $id)
    {
    }
}

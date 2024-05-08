<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BrandInterface;
use App\Traits\RequestToCoreTrait;

class BrandRepository implements BrandInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllBrands($requestData)
    {
        return $this->sendGetRequest($this->url . "/brands", $requestData, __METHOD__);
    }
    public function getBrandById($id)
    {
        return $this->sendGetRequest($this->url . "/brands/".$id, [], __METHOD__);
    }
    public function createBrand(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/brands", $insertData, __METHOD__);
    }
    public function updateBrand(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/brands/".$id, $updateData, __METHOD__);
    }
    public function softDeleteBrand(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/brands/".$id."/soft-delete", __METHOD__);
    }
    public function deleteBrand(int $id)
    {
    }
}

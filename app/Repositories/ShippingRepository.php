<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ShippingInterface;
use App\Traits\RequestToCoreTrait;

class ShippingRepository implements ShippingInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllShippings($requestData)
    {
        return $this->sendGetRequest($this->url . "/shippings", $requestData, __METHOD__);
    }
    public function getAllShippingsWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/shippings/without-pagination", $requestData, __METHOD__);
    }
    public function getShippingById($id)
    {
        return $this->sendGetRequest($this->url . "/shippings/".$id, [], __METHOD__);
    }
    public function createShipping(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/shippings", $insertData, __METHOD__);
    }
    public function updateShipping(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/shippings/".$id, $updateData, __METHOD__);
    }
    public function softDeleteShipping(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/shippings/".$id."/soft-delete", __METHOD__);
    }
    public function deleteShipping(int $id)
    {
    }
}

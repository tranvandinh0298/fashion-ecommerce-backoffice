<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderInterface;
use App\Traits\RequestToCoreTrait;

class OrderRepository implements OrderInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllOrders($requestData)
    {
        return $this->sendGetRequest($this->url . "/orders", $requestData, __METHOD__);
    }
    public function getAllOrdersWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/orders/without-pagination", $requestData, __METHOD__);
    }
    public function getOrderById($id)
    {
        return $this->sendGetRequest($this->url . "/orders/".$id, [], __METHOD__);
    }
    public function createOrder(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/orders", $insertData, __METHOD__);
    }
    public function updateOrder(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/orders/".$id, $updateData, __METHOD__);
    }
    public function softDeleteOrder(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/orders/".$id."/soft-delete", __METHOD__);
    }
    public function deleteOrder(int $id)
    {
    }
}

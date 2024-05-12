<?php

namespace App\Repositories\Interfaces;

interface OrderInterface
{
    public function getAllOrders(array $filters);
    public function getOrderById($id);
    public function createOrder(array $data);
    public function updateOrder(int $id, array $data);
    public function softDeleteOrder(int $id);
    public function deleteOrder(int $id);
}

<?php

namespace App\Repositories\Interfaces;

interface ShippingInterface
{
    public function getAllShippings(array $filters);
    public function getShippingById($id);
    public function createShipping(array $data);
    public function updateShipping(int $id, array $data);
    public function softDeleteShipping(int $id);
    public function deleteShipping(int $id);
}

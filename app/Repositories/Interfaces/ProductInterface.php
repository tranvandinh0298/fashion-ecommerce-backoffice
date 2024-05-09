<?php

namespace App\Repositories\Interfaces;

interface ProductInterface
{
    public function getAllProducts(array $filters);
    public function getProductById($id);
    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function softDeleteProduct(int $id);
    public function deleteProduct(int $id);
}

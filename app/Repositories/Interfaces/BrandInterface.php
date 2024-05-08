<?php

namespace App\Repositories\Interfaces;

interface BrandInterface
{
    public function getAllBrands(array $filters);
    public function getBrandById($id);
    public function createBrand(array $data);
    public function updateBrand(int $id, array $data);
    public function softDeleteBrand(int $id);
    public function deleteBrand(int $id);
}

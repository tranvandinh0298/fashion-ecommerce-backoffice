<?php

namespace App\Services\Interfaces;

interface CategoryInterface
{
    public function getAllCategories();
    public function getCategoryById($id);
    public function createCategory(array $data);
    public function updateCategory(int $id, array $data);
    public function softDeleteCategory(int $id);
    public function deleteCategory(int $id);
}

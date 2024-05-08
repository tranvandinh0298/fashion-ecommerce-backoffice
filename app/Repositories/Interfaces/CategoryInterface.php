<?php

namespace App\Repositories\Interfaces;

interface CategoryInterface
{
    public function getAllCategories(array $filters);
    public function getCategoryById($id);
    public function createCategory(array $data);
    public function updateCategory(int $id, array $data);
    public function softDeleteCategory(int $id);
    public function deleteCategory(int $id);
}

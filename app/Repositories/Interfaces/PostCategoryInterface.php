<?php

namespace App\Repositories\Interfaces;

interface PostCategoryInterface
{
    public function getAllPostCategories(array $filters);
    public function getpostCategoryById($id);
    public function createpostCategory(array $data);
    public function updatepostCategory(int $id, array $data);
    public function softDeletepostCategory(int $id);
    public function deletepostCategory(int $id);
}

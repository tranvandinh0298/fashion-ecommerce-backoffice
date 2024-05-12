<?php

namespace App\Repositories\Interfaces;

interface PostInterface
{
    public function getAllPosts(array $filters);
    public function getPostById($id);
    public function createPost(array $data);
    public function updatePost(int $id, array $data);
    public function softDeletePost(int $id);
    public function deletePost(int $id);
}

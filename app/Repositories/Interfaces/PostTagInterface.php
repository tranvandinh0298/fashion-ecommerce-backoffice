<?php

namespace App\Repositories\Interfaces;

interface PostTagInterface
{
    public function getAllPostTags(array $filters);
    public function getPostTagById($id);
    public function createPostTag(array $data);
    public function updatePostTag(int $id, array $data);
    public function softDeletePostTag(int $id);
    public function deletePostTag(int $id);
}

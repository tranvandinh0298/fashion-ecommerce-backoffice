<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostInterface;
use App\Traits\RequestToCoreTrait;

class PostRepository implements PostInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllPosts($requestData)
    {
        return $this->sendGetRequest($this->url . "/posts", $requestData, __METHOD__);
    }
    public function getAllPostsWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/posts/without-pagination", $requestData, __METHOD__);
    }
    public function getPostById($id)
    {
        return $this->sendGetRequest($this->url . "/posts/".$id, [], __METHOD__);
    }
    public function createPost(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/posts", $insertData, __METHOD__);
    }
    public function updatePost(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/posts/".$id, $updateData, __METHOD__);
    }
    public function softDeletePost(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/posts/".$id."/soft-delete", __METHOD__);
    }
    public function deletePost(int $id)
    {
    }
}

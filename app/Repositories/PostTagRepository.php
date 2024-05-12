<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostTagInterface;
use App\Traits\RequestToCoreTrait;

class PostTagRepository implements PostTagInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllPostTags($requestData)
    {
        return $this->sendGetRequest($this->url . "/post-tags", $requestData, __METHOD__);
    }
    public function getAllPostTagsWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/post-tags/without-pagination", $requestData, __METHOD__);
    }
    public function getPostTagById($id)
    {
        return $this->sendGetRequest($this->url . "/post-tags/".$id, [], __METHOD__);
    }
    public function createPostTag(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/post-tags", $insertData, __METHOD__);
    }
    public function updatePostTag(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/post-tags/".$id, $updateData, __METHOD__);
    }
    public function softDeletePostTag(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/post-tags/".$id."/soft-delete", __METHOD__);
    }
    public function deletePostTag(int $id)
    {
    }
}

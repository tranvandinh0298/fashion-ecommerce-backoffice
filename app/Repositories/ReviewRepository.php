<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewInterface;
use App\Traits\RequestToCoreTrait;

class ReviewRepository implements ReviewInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllReviews($requestData)
    {
        return $this->sendGetRequest($this->url . "/reviews", $requestData, __METHOD__);
    }
    public function getAllReviewsWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/reviews/without-pagination", $requestData, __METHOD__);
    }
    public function getReviewById($id)
    {
        return $this->sendGetRequest($this->url . "/reviews/".$id, [], __METHOD__);
    }
    public function createReview(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/reviews", $insertData, __METHOD__);
    }
    public function updateReview(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/reviews/".$id, $updateData, __METHOD__);
    }
    public function softDeleteReview(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/reviews/".$id."/soft-delete", __METHOD__);
    }
    public function deleteReview(int $id)
    {
    }
}

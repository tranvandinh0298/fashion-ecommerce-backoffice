<?php

namespace App\Repositories\Interfaces;

interface ReviewInterface
{
    public function getAllReviews(array $filters);
    public function getReviewById($id);
    public function createReview(array $data);
    public function updateReview(int $id, array $data);
    public function softDeleteReview(int $id);
    public function deleteReview(int $id);
}

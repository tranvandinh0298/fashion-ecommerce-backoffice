<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Review;
use App\Repositories\ReviewRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class ReviewService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = new ReviewRepository();
    }

    public function getAllReviews()
    {
        $requestData = $this->getFilterData();

        $data = $this->reviewRepository->getAllReviews($requestData);

        if (empty($data)) {
            $data = [
                "content" => [],
                "page" => [
                    "size" => $requestData['size'],
                    "totalElements" => 0,
                    "totalPages" => 0,
                    "number" => 0
                ],
            ];
        }

        $content = $data['content'];
        $data['content'] = $this->convertListOfReviewsToHTML($content);

        return $data;
    }

    public function getAllReviewsWithoutPagination($requestData)
    {
        $data = $this->reviewRepository->getAllReviewsWithoutPagination($requestData);

        $data = $this->convertListOfReviewDTOs($data);

        return $data;
    }

    public function getReviewById($reviewId)
    {
        $data = $this->reviewRepository->getReviewById($reviewId);

        $data = $this->convertListOfReviewDTOs($data);

        return $data;
    }

    public function createReview(array $insertData)
    {
        $data = $this->reviewRepository->createReview($insertData);

        return $data;
    }

    public function updateReview(int $reviewId, array $updateData)
    {
        $data = $this->reviewRepository->updateReview($reviewId, $updateData);

        return $data;
    }

    public function softDeleteReview(int $reviewId)
    {
        $data = $this->reviewRepository->softDeleteReview($reviewId);

        return $data;
    }

    public function deleteReview(int $id): bool
    {
        return true;
    }

    protected function convertListOfReviewDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($review) {
                return $this->convertReviewDTOtoReview($review);
            });
            return $data;
        }
    }

    protected function convertReviewDTOtoReview($reviewDTO)
    {
        return [
            'reviewId' => $reviewDTO['reviewId'],
            'user' => $reviewDTO['userDTO'],
            'product' => $reviewDTO['productDTO'],
            'rate' => $reviewDTO['rate'],
            'review' => $reviewDTO['review'],
            'status' => $reviewDTO['status'],
        ];
    }

    protected function convertListOfReviewsToHTML($reviews) {
        if (!empty($reviews)) {
            $data = collect($reviews)->map(function ($review) {
                return $this->convertReviewToHTML($this->convertReviewDTOtoReview($review));
            });
            return $data;
        }
    }

    protected function convertReviewToHTML($review) {
        $review['rate'] = $this->displayRating($review['rate']);
        $review['status'] = $this->displayStatus($review['status']);
        $review['action'] = $this->displayAction($review['reviewId'], 'reviews');

        return $review;
    }
}

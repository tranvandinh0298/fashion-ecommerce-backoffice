<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\PostCategory;
use App\Repositories\PostCategoryRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class PostCategoryService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $postCategoryRepository;

    public function __construct()
    {
        $this->postCategoryRepository = new PostCategoryRepository();
    }

    public function getAllPostCategories()
    {
        $requestData = $this->getFilterData();

        $data = $this->postCategoryRepository->getAllPostCategories($requestData);

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
        $data['content'] = $this->convertListOfPostCategoriesToHTML($content);

        return $data;
    }

    public function getAllPostCategoriesWithoutPagination($requestData)
    {
        $data = $this->postCategoryRepository->getAllPostCategoriesWithoutPagination($requestData);

        $data = $this->convertListOfPostCategoryDTOs($data);

        return $data;
    }

    public function getPostCategoryById($postCategoryId)
    {
        $data = $this->postCategoryRepository->getPostCategoryById($postCategoryId);

        $data = $this->convertPostCategoryDTOtoPostCategory($data);

        return $data;
    }

    public function createPostCategory(array $insertData)
    {
        $data = $this->postCategoryRepository->createPostCategory($insertData);

        return $data;
    }

    public function updatePostCategory(int $postCategoryId, array $updateData)
    {
        $data = $this->postCategoryRepository->updatePostCategory($postCategoryId, $updateData);

        return $data;
    }

    public function softDeletePostCategory(int $postCategoryId)
    {
        $data = $this->postCategoryRepository->softDeletePostCategory($postCategoryId);

        return $data;
    }

    public function deletePostCategory(int $id): bool
    {
        return true;
    }

    protected function convertListOfPostCategoryDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($postCategory) {
                return $this->convertPostCategoryDTOtoPostCategory($postCategory);
            });
            return $data;
        }
    }

    protected function convertPostCategoryDTOtoPostCategory($postCategoryDTO)
    {
        return [
            'postCategoryId' => $postCategoryDTO['postCategoryId'],
            'title' => $postCategoryDTO['title'],
            'slug' => $postCategoryDTO['slug'],
            'status' => $postCategoryDTO['status'],
        ];
    }

    protected function convertListOfPostCategoriesToHTML($postCategorys) {
        if (!empty($postCategorys)) {
            $data = collect($postCategorys)->map(function ($postCategory) {
                return $this->convertPostCategoryToHTML($this->convertPostCategoryDTOtoPostCategory($postCategory));
            });
            return $data;
        }
    }

    protected function convertPostCategoryToHTML($postCategory) {
        $postCategory['status'] = $this->displayStatus($postCategory['status']);
        $postCategory['action'] = $this->displayAction($postCategory['postCategoryId'], 'postCategories');

        return $postCategory;
    }
}

<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Repositories\CategoryRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function getAllCategories()
    {
        $requestData = $this->getFilterData();

        $data = $this->categoryRepository->getAllCategories($requestData);

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
        $data['content'] = $this->convertListOfCategoriesToHTML($content);

        return $data;
    }

    public function getAllCategoriesWithoutPagination($requestData)
    {
        $data = $this->categoryRepository->getAllCategoriesWithoutPagination($requestData);

        if (empty($data)) {
            $data = [
                "content" => [],
            ];
        }

        $content = $data['content'];
        $data['content'] = $this->convertListOfCategoryDTOs($content);

        return $data['content'];
    }

    public function getCategoryById($categoryId)
    {
        $data = $this->categoryRepository->getCategoryById($categoryId);

        $data = $this->convertCategoryDTOtoCategory($data);

        if (!empty($data)) {
            $data['photo'] = url($data['photo']);
        }

        return $data;
    }

    public function createCategory(array $data)
    {
        $insertData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'summary' => $data['summary'],
            'photo' => $data['photo'],
            'status' => $data['status'],
            'isParent' => $data['isParent'] ?? 0,
            'parentCategoryId' => $data['parentCategoryId'] ?? null,
        ];

        $data = $this->categoryRepository->createCategory($insertData);

        return $data;
    }

    public function updateCategory(int $categoryId, array $data)
    {
        $updateData = [
            'title' => $data['title'],
            'summary' => $data['summary'],
            'photo' => $data['photo'],
            'status' => $data['status'],
            'isParent' => $data['isParent'] ?? 0,
            'parentCategoryId' => $data['parentCategoryId'] ?? null,
        ];

        $data = $this->categoryRepository->updateCategory($categoryId, $updateData);

        return $data;
    }

    public function softDeleteCategory(int $categoryId)
    {
        $data = $this->categoryRepository->softDeleteCategory($categoryId);

        return $data;
    }

    public function deleteCategory(int $id): bool
    {
        return true;
    }

    protected function convertListOfCategoryDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($category) {
                return $this->convertCategoryDTOtoCategory($category);
            });
            return $data;
        }
    }

    protected function convertCategoryDTOtoCategory($categoryDTO)
    {
        return [
            'categoryId' => $categoryDTO['categoryId'],
            'title' => $categoryDTO['title'],
            'slug' => $categoryDTO['slug'],
            'summary' => $categoryDTO['summary'],
            'isParent' => $categoryDTO['isParent'],
            'parentCategory' => $categoryDTO['parentCategoryDTO'] ?? null,
            'photo' => $categoryDTO['photo'],
            'status' => $categoryDTO['status'],
            'action' => $categoryDTO['categoryId'],
        ];
    }

    protected function convertListOfCategoriesToHTML($categories) {
        if (!empty($categories)) {
            $data = collect($categories)->map(function ($category) {
                return $this->convertCategoryToHTML($this->convertCategoryDTOtoCategory($category));
            });
            return $data;
        }
    }

    protected function convertCategoryToHTML($category) {
        $category['isParent'] = $this->displayYesNo($category['isParent']);
        $category['photo'] = $this->displayPhoto($category['photo']);
        $category['status'] = $this->displayStatus($category['status']);
        $category['action'] = $this->displayAction($category['categoryId'], 'categories');

        return $category;
    }
}

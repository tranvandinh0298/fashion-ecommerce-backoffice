<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class BrandService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $brandRepository;

    public function __construct()
    {
        $this->brandRepository = new BrandRepository();
    }

    public function getAllBrands()
    {
        $requestData = $this->getFilterData();

        $data = $this->brandRepository->getAllBrands($requestData);

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
        $data['content'] = $this->convertListOfBrandsToHTML($content);

        return $data;
    }

    public function getAllBrandsWithoutPagination($requestData)
    {
        $data = $this->brandRepository->getAllBrandsWithoutPagination($requestData);

        $data = $this->convertListOfBrandDTOs($data);

        return $data;
    }

    public function getBrandById($brandId)
    {
        $data = $this->brandRepository->getBrandById($brandId);

        $data = $this->convertBrandDTOtoBrand($data);

        return $data;
    }

    public function createBrand(array $insertData)
    {
        // $insertData = [
        //     'title' => $data['title'],
        //     'slug' => $data['slug'],
        //     'status' => $data['status'],
        // ];

        $data = $this->brandRepository->createBrand($insertData);

        return $data;
    }

    public function updateBrand(int $brandId, array $updateData)
    {
        // $updateData = [
        //     'title' => $data['title'],
        //     'status' => $data['status'],
        // ];

        $data = $this->brandRepository->updateBrand($brandId, $updateData);

        return $data;
    }

    public function softDeleteBrand(int $brandId)
    {
        $data = $this->brandRepository->softDeleteBrand($brandId);

        return $data;
    }

    public function deleteBrand(int $id): bool
    {
        return true;
    }

    protected function convertListOfBrandDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($brand) {
                return $this->convertBrandDTOtoBrand($brand);
            });
            return $data;
        }
    }

    protected function convertBrandDTOtoBrand($brandDTO)
    {
        return [
            'brandId' => $brandDTO['brandId'],
            'title' => $brandDTO['title'],
            'slug' => $brandDTO['slug'],
            'status' => $brandDTO['status'],
        ];
    }

    protected function convertListOfBrandsToHTML($brands) {
        if (!empty($brands)) {
            $data = collect($brands)->map(function ($brand) {
                return $this->convertBrandToHTML($this->convertBrandDTOtoBrand($brand));
            });
            return $data;
        }
    }

    protected function convertBrandToHTML($brand) {
        $brand['status'] = $this->displayStatus($brand['status']);
        $brand['action'] = $this->displayAction($brand['brandId'], 'brands');

        return $brand;
    }
}

<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class ProductService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProducts()
    {
        $requestData = $this->getFilterData();

        $data = $this->productRepository->getAllProducts($requestData);

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
        $data['content'] = $this->convertListOfProductsToHTML($content);

        return $data;
    }

    public function getAllProductsWithoutPagination($requestData)
    {
        $data = $this->productRepository->getAllProductsWithoutPagination($requestData);

        $data = $this->convertListOfProductDTOs($data);

        return $data;
    }

    public function getProductById($productId)
    {
        $data = $this->productRepository->getProductById($productId);

        $data = $this->convertProductDTOtoProduct($data);

        return $data;
    }

    public function createProduct(array $insertData)
    {
        $data = $this->productRepository->createProduct($insertData);

        return $data;
    }

    public function updateProduct(int $productId, array $updateData)
    {
        $data = $this->productRepository->updateProduct($productId, $updateData);

        return $data;
    }

    public function softDeleteProduct(int $productId)
    {
        $data = $this->productRepository->softDeleteProduct($productId);

        return $data;
    }

    public function deleteProduct(int $id): bool
    {
        return true;
    }

    protected function convertListOfProductDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($product) {
                return $this->convertProductDTOtoProduct($product);
            });
            return $data;
        }
    }

    protected function convertProductDTOtoProduct($productDTO)
    {
        return [
            'productId' => $productDTO['productId'],
            'title' => $productDTO['title'],
            'slug' => $productDTO['slug'],
            'summary' => $productDTO['summary'],
            'description' => $productDTO['description'],
            'photo' => url($productDTO['photo']),
            'stock' => $productDTO['stock'],
            'size' => $productDTO['size'],
            'condition' => $productDTO['condition'],
            'status' => $productDTO['status'],
            'price' => $productDTO['price'],
            'discount' => $productDTO['discount'],
            'isFeatured' => $productDTO['isFeatured'],
            'category' => $productDTO['categoryDTO'],
            'childCategory' => $productDTO['childCategoryDTO'],
            'brand' => $productDTO['brandDTO'],
        ];
    }

    protected function convertListOfProductsToHTML($products)
    {
        if (!empty($products)) {
            $data = collect($products)->map(function ($product) {
                return $this->convertProductToHTML($this->convertProductDTOtoProduct($product));
            });
            return $data;
        }
    }

    protected function convertProductToHTML($product)
    {
        $product['isFeatured'] = $this->displayYesNo($product['isFeatured']);
        $product['photo'] = $this->displayPhoto($product['photo']);
        $product['status'] = $this->displayStatus($product['status']);
        $product['action'] = $this->displayAction($product['productId'], 'products');

        return $product;
    }
}

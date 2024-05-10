<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Shipping;
use App\Repositories\ShippingRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $shippingRepository;

    public function __construct()
    {
        $this->shippingRepository = new ShippingRepository();
    }

    public function getAllShippings()
    {
        $requestData = $this->getFilterData();

        $data = $this->shippingRepository->getAllShippings($requestData);

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
        $data['content'] = $this->convertListOfShippingsToHTML($content);

        return $data;
    }

    public function getAllShippingsWithoutPagination($requestData)
    {
        $data = $this->shippingRepository->getAllShippingsWithoutPagination($requestData);

        $data = $this->convertListOfShippingDTOs($data);

        return $data;
    }

    public function getShippingById($shippingId)
    {
        $data = $this->shippingRepository->getShippingById($shippingId);

        $data = $this->convertShippingDTOtoShipping($data);

        return $data;
    }

    public function createShipping(array $insertData)
    {
        $data = $this->shippingRepository->createShipping($insertData);

        return $data;
    }

    public function updateShipping(int $shippingId, array $updateData)
    {
        $data = $this->shippingRepository->updateShipping($shippingId, $updateData);

        return $data;
    }

    public function softDeleteShipping(int $shippingId)
    {
        $data = $this->shippingRepository->softDeleteShipping($shippingId);

        return $data;
    }

    public function deleteShipping(int $id): bool
    {
        return true;
    }

    protected function convertListOfShippingDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($shipping) {
                return $this->convertShippingDTOtoShipping($shipping);
            });
            return $data;
        }
    }

    protected function convertShippingDTOtoShipping($shippingDTO)
    {
        return [
            'shippingId' => $shippingDTO['shippingId'],
            'type' => $shippingDTO['type'],
            'price' => $shippingDTO['price'],
            'status' => $shippingDTO['status'],
        ];
    }

    protected function convertListOfShippingsToHTML($shippings)
    {
        if (!empty($shippings)) {
            $data = collect($shippings)->map(function ($shipping) {
                return $this->convertShippingToHTML($this->convertShippingDTOtoShipping($shipping));
            });
            return $data;
        }
    }

    protected function convertShippingToHTML($shipping)
    {
        $shipping['status'] = $this->displayStatus($shipping['status']);
        $shipping['action'] = $this->displayAction($shipping['shippingId'], 'shippings');

        return $shipping;
    }
}

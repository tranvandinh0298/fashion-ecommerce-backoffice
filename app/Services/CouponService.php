<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class CouponService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $couponRepository;

    public function __construct()
    {
        $this->couponRepository = new CouponRepository();
    }

    public function getAllCoupons()
    {
        $requestData = $this->getFilterData();

        $data = $this->couponRepository->getAllCoupons($requestData);

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
        $data['content'] = $this->convertListOfCouponsToHTML($content);

        return $data;
    }

    public function getCouponById($couponId)
    {
        $data = $this->couponRepository->getCouponById($couponId);

        return $data;
    }

    public function createCoupon(array $data)
    {
        $insertData = [
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'status' => $data['status'],
        ];

        $data = $this->couponRepository->createCoupon($insertData);

        return $data;
    }

    public function updateCoupon(int $couponId, array $data)
    {
        $updateData = [
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'status' => $data['status'],
        ];

        $data = $this->couponRepository->updateCoupon($couponId, $updateData);

        return $data;
    }

    public function softDeleteCoupon(int $couponId)
    {
        $data = $this->couponRepository->softDeleteCoupon($couponId);

        return $data;
    }

    public function deleteCoupon(int $id): bool
    {
        return true;
    }

    protected function convertListOfCouponDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($coupon) {
                return $this->convertCouponDTOtoCoupon($coupon);
            });
            return $data;
        }
    }

    protected function convertCouponDTOtoCoupon($couponDTO)
    {
        return [
            'couponId' => $couponDTO['couponId'],
            'code' => $couponDTO['code'],
            'type' => $couponDTO['type'],
            'value' => $couponDTO['value'],
            'status' => $couponDTO['status'],
        ];
    }

    protected function convertListOfCouponsToHTML($coupons) {
        if (!empty($coupons)) {
            $data = collect($coupons)->map(function ($coupon) {
                return $this->convertCouponToHTML($this->convertCouponDTOtoCoupon($coupon));
            });
            return $data;
        }
    }

    protected function convertCouponToHTML($coupon) {
        $coupon['status'] = $this->displayStatus($coupon['status']);
        $coupon['action'] = $this->displayAction($coupon['couponId'], 'coupons');

        return $coupon;
    }
}

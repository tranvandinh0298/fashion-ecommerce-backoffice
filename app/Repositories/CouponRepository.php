<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CouponInterface;
use App\Traits\RequestToCoreTrait;

class CouponRepository implements CouponInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllCoupons($requestData)
    {
        return $this->sendGetRequest($this->url . "/coupons", $requestData, __METHOD__);
    }
    public function getCouponById($id)
    {
        return $this->sendGetRequest($this->url . "/coupons/".$id, [], __METHOD__);
    }
    public function createCoupon(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/coupons", $insertData, __METHOD__);
    }
    public function updateCoupon(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/coupons/".$id, $updateData, __METHOD__);
    }
    public function softDeleteCoupon(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/coupons/".$id."/soft-delete", __METHOD__);
    }
    public function deleteCoupon(int $id)
    {
    }
}

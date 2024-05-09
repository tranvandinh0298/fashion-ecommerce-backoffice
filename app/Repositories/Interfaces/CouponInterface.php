<?php

namespace App\Repositories\Interfaces;

interface CouponInterface
{
    public function getAllCoupons(array $filters);
    public function getCouponById($id);
    public function createCoupon(array $data);
    public function updateCoupon(int $id, array $data);
    public function softDeleteCoupon(int $id);
    public function deleteCoupon(int $id);
}

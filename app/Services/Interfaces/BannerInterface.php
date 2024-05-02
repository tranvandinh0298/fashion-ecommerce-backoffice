<?php

namespace App\Services\Interfaces;

use App\Models\Banner;

interface BannerInterface
{
    public function getAllBanners();
    public function getBannerById();
    public function createBanner(array $data);
    public function updateBanner(int $id, array $data);
    public function softDeleteBanner(int $id);
    public function deleteBanner(int $id);
}

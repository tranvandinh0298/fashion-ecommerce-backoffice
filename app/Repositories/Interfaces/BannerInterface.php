<?php

namespace App\Repositories\Interfaces;

interface BannerInterface
{
    public function getAllBanners(array $filters);
    public function getBannerById($id);
    public function createBanner(array $data);
    public function updateBanner(int $id, array $data);
    public function softDeleteBanner(int $id);
    public function deleteBanner(int $id);
}

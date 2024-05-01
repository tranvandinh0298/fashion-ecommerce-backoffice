<?php

namespace App\Services\Interfaces;

use App\Models\Banner;

interface BannerInterface
{
    public function getAllBanners(): array;
    public function getBannerById(): ?Banner;
    public function createBanner(array $data): ?Banner;
    public function updateBanner(int $id, array $data): void;
    public function softDeleteBanner(int $id): bool;
    public function deleteBanner(int $id): bool;
}

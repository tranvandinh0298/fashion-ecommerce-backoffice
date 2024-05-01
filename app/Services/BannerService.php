<?php

namespace App\Services;

use App\Models\Banner;
use App\Services\Interfaces\BannerInterface;
use App\Traits\LogTrait;
use App\Traits\RequestToCoreTrait;

class BannerService implements BannerInterface
{
    // use LogTrait;
    use RequestToCoreTrait;

    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }

    public function getAllBanners(): array
    {
        $pageNum = request()->query("page", 1) - 1;
        $pageSize = request()->query("pageSize", 10);
        $requestData = [
            'page' => $pageNum,
            'limit' => $pageSize,
        ];

        $data = $this->sendGetRequest($this->url . "/banners", $requestData);

        return $data;
    }

    public function getBannerById(): ?Banner
    {
        return new Banner();
    }

    public function createBanner(array $data): ?Banner
    {
        return new Banner();
    }

    public function updateBanner(int $id, array $data): void
    {
    }

    public function softDeleteBanner(int $id): bool
    {
        return true;
    }

    public function deleteBanner(int $id): bool
    {
        return true;
    }
}

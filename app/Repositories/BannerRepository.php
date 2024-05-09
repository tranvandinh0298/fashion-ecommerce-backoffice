<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BannerInterface;
use App\Traits\RequestToCoreTrait;

class BannerRepository implements BannerInterface
{
    use RequestToCoreTrait;
    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }
    public function getAllBanners($requestData)
    {
        return $this->sendGetRequest($this->url . "/banners", $requestData, __METHOD__);
    }
    public function getAllBannersWithoutPagination($requestData)
    {
        return $this->sendGetRequest($this->url . "/banners/without-pagination", $requestData, __METHOD__);
    }
    public function getBannerById($id)
    {
        return $this->sendGetRequest($this->url . "/banners/".$id, [], __METHOD__);
    }
    public function createBanner(array $insertData)
    {
        return $this->sendPostRequest($this->url . "/banners", $insertData, __METHOD__);
    }
    public function updateBanner(int $id, array $updateData)
    {
        return $this->sendPatchRequest($this->url . "/banners/".$id, $updateData, __METHOD__);
    }
    public function softDeleteBanner(int $id)
    {
        return $this->sendDeleteRequest($this->url . "/banners/".$id."/soft-delete", __METHOD__);
    }
    public function deleteBanner(int $id)
    {
    }
}

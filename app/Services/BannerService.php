<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Banner;
use App\Services\Interfaces\BannerInterface;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class BannerService implements BannerInterface
{
    use RequestToCoreTrait;
    use DisplayHtmlTrait;

    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }

    public function getAllBanners()
    {
        $requestData = $this->getFilterData();

        $data = $this->sendGetRequest($this->url . "/banners", $requestData, __METHOD__);

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
        if (!empty($content)) {
            $data['content'] = collect($content)->map(function ($banner) {
                return [
                    'bannerId' => $banner['bannerId'],
                    'title' => $banner['title'],
                    'slug' => $banner['slug'],
                    'photo' => $this->displayPhoto($banner['photo']),
                    'status' => $this->displayStatus($banner['status']),
                    'action' => $this->displayAction($banner['bannerId'])
                ];
            });
        }

        return $data;
    }

    public function getBannerById($bannerId)
    {
        $requestData = [];

        $data = $this->sendGetRequest($this->url . "/banners/".$bannerId, $requestData, __METHOD__);

        if (!empty($data)) {
            $data['photo'] = url($data['photo']);
        }

        return $data;
    }

    public function createBanner(array $data)
    {
        $requestData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'photo' => parse_url($data['photo'])['path'],
            'status' => $data['status'],
        ];

        $data = $this->sendPostRequest($this->url . "/banners", $requestData, __METHOD__);

        return $data;
    }

    public function updateBanner(int $bannerId, array $data)
    {
        $requestData = [
            'title' => $data['title'],
            'description' => $data['description'],
            'photo' => parse_url($data['photo'])['path'],
            'status' => $data['status'],
        ];

        $data = $this->sendPatchRequest($this->url . "/banners/".$bannerId, $requestData, __METHOD__);

        return $data;
    }

    public function softDeleteBanner(int $bannerId)
    {
        $data = $this->sendDeleteRequest($this->url . "/banners/".$bannerId."/soft-delete", __METHOD__);

        return $data;
    }

    public function deleteBanner(int $id): bool
    {
        return true;
    }
}

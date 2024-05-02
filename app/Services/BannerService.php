<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Banner;
use App\Services\Interfaces\BannerInterface;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;

class BannerService implements BannerInterface
{
    // use LogTrait;
    use RequestToCoreTrait;
    use DisplayHtmlTrait;

    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }

    public function getAllBanners()
    {
        $requestData = [];
        $pageSize = request()->query("length", 10);
        $pageNum = request()->query("start", 0) / $pageSize;
        $requestData = [
            'page' => $pageNum,
            'limit' => $pageSize,
        ];

        $data = $this->sendGetRequest($this->url . "/banners", $requestData, __METHOD__);

        $content = $data['content'];

        $data['content'] = collect($content)->map(function ($banner) {
            return [
                0 => $banner['bannerId'],
                1 => $banner['title'],
                2 => $banner['slug'],
                3 => $this->displayPhoto($banner['photo']),
                4 => $this->displayStatus($banner['status']),
                5 => $this->displayAction($banner['bannerId'])
            ];
        });

        return $data;
    }

    public function getBannerById()
    {
        return new Banner();
    }

    public function createBanner(array $data)
    {
        $data = $this->sendPostRequest($this->url . "/banners", $data, __METHOD__);

        return $data;
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

    protected function extractData(Response $response): array
    {
        $jsonToArray = $response->json();
        /**
         * các TH cần throw lỗi ko tìm thấy partner
         * * request client hoặc server xảy ra lỗi
         * * responseBody không chứa tham số resultCode
         * * responseBody chứa tham số resultCode không phải mã thành công
         */
        if (empty($jsonToArray['resultCode'])) {
            throw new RestException("Lỗi kết nối");
        }

        $data = $jsonToArray['data'] ?? [];

        return $data;
    }
}

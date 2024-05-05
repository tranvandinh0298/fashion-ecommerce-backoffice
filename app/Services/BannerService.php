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

    protected function getFilterData()
    {
        $searchData = [
            'filters' => [],
            'sorts' => [],
            'page' => 0,
            'size' => 10,
        ];
        $request = request();

        $searchData['size'] = $request->query("length", 10);

        $searchData['page'] = $request->query("start", 0) / $searchData['size'];

        // $filters = $request->query("")

        $sorts = $request->query("order");
        foreach ($sorts as $sort) {
            $searchData['sorts'][] = [
                'key' => $this->convertDatatableColumnToField($sort['column']),
                'direction' => strtoupper($sort['dir'])
            ];
        }

        return $searchData;
    }

    protected function convertDatatableColumnToField($column)
    {
        return $this->fieldList()[$column];
    }

    protected function fieldList() {
        return [
            0 => "bannerId",
            1 => "title",
            2 => "slug",
            3 => 'photo',
            4 => 'status',
            5 => 'action',
        ];
    }
}

<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class BannerService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $bannerRepository;

    public function __construct()
    {
        $this->bannerRepository = new BannerRepository();
    }

    public function getAllBanners()
    {
        $requestData = $this->getFilterData();

        $data = $this->bannerRepository->getAllBanners($requestData);

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
        $data['content'] = $this->convertListOfBannersToHTML($content);

        return $data;
    }

    public function getBannerById($bannerId)
    {
        $data = $this->bannerRepository->getBannerById($bannerId);

        if (!empty($data)) {
            $data['photo'] = url($data['photo']);
        }

        return $data;
    }

    public function createBanner(array $data)
    {
        $insertData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'photo' => $data['photo'],
            'status' => $data['status'],
        ];

        $data = $this->bannerRepository->createBanner($insertData);

        return $data;
    }

    public function updateBanner(int $bannerId, array $data)
    {
        $updateData = [
            'categoryId' => $bannerId,
            'title' => $data['title'],
            'description' => $data['description'],
            'photo' => $data['photo'],
            'status' => $data['status'],
        ];

        $data = $this->bannerRepository->updateBanner($bannerId, $updateData);

        return $data;
    }

    public function softDeleteBanner(int $bannerId)
    {
        $data = $this->bannerRepository->softDeleteBanner($bannerId);

        return $data;
    }

    public function deleteBanner(int $id): bool
    {
        return true;
    }

    protected function convertListOfBannerDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($banner) {
                return $this->convertBannerDTOtoBanner($banner);
            });
            return $data;
        }
    }

    protected function convertBannerDTOtoBanner($bannerDTO)
    {
        return [
            'bannerId' => $bannerDTO['bannerId'],
            'title' => $bannerDTO['title'],
            'slug' => $bannerDTO['slug'],
            'photo' => $bannerDTO['photo'],
            'status' => $bannerDTO['status'],
            'action' => $bannerDTO['bannerId'],
        ];
    }

    protected function convertListOfBannersToHTML($banners) {
        if (!empty($banners)) {
            $data = collect($banners)->map(function ($banner) {
                return $this->convertBannerToHTML($this->convertBannerDTOtoBanner($banner));
            });
            return $data;
        }
    }

    protected function convertBannerToHTML($banner) {
        $banner['photo'] = $this->displayPhoto($banner['photo']);
        $banner['status'] = $this->displayStatus($banner['status']);
        $banner['action'] = $this->displayAction($banner['bannerId'], 'banners');

        return $banner;
    }
}

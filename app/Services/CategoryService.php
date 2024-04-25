<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    use LogTrait;

    protected $url;

    public function __construct()
    {
        $this->url = config("rest.core.url");
    }

    public function getAllCategories(Request $request)
    {
        $pageNum = $request->query("page", 1) - 1;
        $pageSize = $request->query("pageSize", 10);

        $this->logInfo(__METHOD__ . ' - REQUEST: ' . json_encode([
            'url' => $this->url . "/categories",
            'request' => $request->all()
        ], 256));

        $response = Http::get($this->url . "/categories", ['page' => $pageNum, 'limit' => $pageSize]);

        $this->logInfo(__METHOD__ . ' - RESPONSE: ' . json_encode($response->json(), 256));

        // extract data from response
        $data = $this->extractData($response);

        // return data
        return $data;
    }

    public function deleteImage($imageId)
    {
        $this->logInfo(__METHOD__ . ' - REQUEST: ' . json_encode(array_merge([
            'url' => $this->url . "/images",
        ], []), 256));

        $response = Http::delete($this->url . '/images/' . $imageId);

        $this->logInfo(__METHOD__ . ' - RESPONSE: ' . json_encode($response->json(), 256));

        // extract data from response
        $data = $this->extractData($response);

        // return data
        return $data;
    }

    /**
     * trích xuất dữ liệu
     * 
     * @author dinhtv
     * @param \Illuminate\Http\Client\Response
     * @throws \Exception
     * @return array|null
     * @since 12/10/2023
     */
    protected function extractData(Response $response): array
    {
        $extractData = [];
        $jsonToArray = $response->json();

        /**
         * các TH cần throw lỗi ko tìm thấy partner
         * * request client hoặc server xảy ra lỗi
         * * responseBody không chứa tham số returnCode
         * * responseBody chứa tham số returnCode không phải mã thành công
         */
        if ($response->failed() || empty($jsonToArray['resultCode']) || $jsonToArray['resultCode'] != CORE_SUCCESS_CODE) {
            throw new RestException("Lỗi kết nối");
        }

        // extractData
        if (empty($jsonToArray['data'])) {
            throw new RestException("Lỗi không có dữ liệu trả về");
        } else {
            $data = $jsonToArray['data'];
        }

        return $data;
    }
}

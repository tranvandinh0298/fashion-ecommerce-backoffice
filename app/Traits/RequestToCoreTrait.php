<?php

namespace App\Traits;

use App\Exceptions\RestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait RequestToCoreTrait
{
    use LogTrait;

    public function sendGetRequest($url, $data)
    {
        $this->logRequestBeforeSend($url, $data);

        $response = Http::get($url, $data);

        $this->logResponseAfterReceive($response);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendPostRequest($url, $data)
    {
        $this->logRequestBeforeSend($url, $data);

        $response = Http::post($url, $data);

        $this->logResponseAfterReceive($response);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendPatchRequest($url, $data)
    {
        $this->logRequestBeforeSend($url, $data);

        $response = Http::patch($url, $data);

        $this->logResponseAfterReceive($response);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendDeleteRequest($url, $data)
    {
        $this->logRequestBeforeSend($url, $data);

        $response = Http::delete($url, $data);

        $this->logResponseAfterReceive($response);

        $data = $this->extractData($response);

        return $data;
    }

    public function logRequestBeforeSend($url, $data)
    {
        $this->logInfo(__METHOD__ . ' - REQUEST: ' . json_encode([
            'url' => $url,
            'requestData' => $data
        ], 256));
    }

    public function logResponseAfterReceive(Response $response)
    {
        $this->logInfo(__METHOD__ . ' - RESPONSE: ' . json_encode($response->json(), 256));
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

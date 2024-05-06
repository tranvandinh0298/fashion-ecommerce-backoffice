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

    public function sendGetRequest($url, $data, $method = __METHOD__)
    {
        $this->logRequestBeforeSend($url, $data, $method);

        $response = Http::withBody(json_encode($data), 'application/json')->get($url);

        $this->logResponseAfterReceive($response, $method);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendPostRequest($url, $data, $method = __METHOD__)
    {
        $this->logRequestBeforeSend($url, $data, $method);

        $response = Http::post($url, $data);

        $this->logResponseAfterReceive($response, $method);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendPatchRequest($url, $data, $method = __METHOD__)
    {
        $this->logRequestBeforeSend($url, $data, $method);

        $response = Http::patch($url, $data);

        $this->logResponseAfterReceive($response, $method);

        $data = $this->extractData($response);

        return $data;
    }

    public function sendDeleteRequest($url, $method = __METHOD__)
    {
        $this->logRequestBeforeSend($url, [], $method);

        $response = Http::delete($url);

        $this->logResponseAfterReceive($response, $method);

        $data = $this->extractBoolResult($response);

        return $data;
    }

    public function logRequestBeforeSend($url, $data, $method)
    {
        $this->logInfo($method . ' - REQUEST: ' . json_encode([
            'url' => $url,
            'requestData' => $data
        ], 256));
    }

    public function logResponseAfterReceive(Response $response, $method)
    {
        $this->logInfo($method . ' - RESPONSE: ' . json_encode($response->json(), 256));
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

        $filters = $request->query("search", []);
        $searchData['filters'] = json_decode($filters['value']);

        $sorts = $request->query("order");
        $columns = $request->query("columns");
        foreach ($sorts as $sort) {
            $searchData['sorts'][] = [
                'key' => $columns[$sort['column']]['name'],
                'direction' => strtoupper($sort['dir'])
            ];
        }

        return $searchData;
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

    protected function extractBoolResult(Response $response): bool
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

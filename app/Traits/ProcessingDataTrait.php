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

trait ProcessingDataTrait
{
    protected function getFilterData()
    {
        $searchData = [
            'filters' => [],
            'sorts' => [],
            'page' => 0,
            'size' => 10,
        ];

        Log::info('searchData init: '. json_encode($searchData));

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

        Log::info('searchData after: '. json_encode($searchData));

        return $searchData;
    }
}

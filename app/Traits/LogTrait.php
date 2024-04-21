<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

trait LogTrait
{
    public function logLine()
    {
        Log::info("===========================================================");
    }

    public function prefixLog()
    {
        return request()->requestId ?? request()->merTrxId ?? request()->ip();
    }

    public function logInfo($message)
    {
        $message = is_string($message) ? $message : json_encode($message, 256);
        Log::info($this->prefixLog() . " - " . $message);
    }

    public function startLog($requestData)
    {
        $this->logLine();
        $this->logInfo("REQUEST: " . json_encode($requestData, 256));
    }

    public function endLog($responseData)
    {
        $this->logInfo("RESPONSE: " . json_encode($responseData, 256));
        $this->logLine();
    }
}

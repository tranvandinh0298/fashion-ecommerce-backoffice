<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $files = Storage::disk('images')->files();
        foreach($files as $file) {
            echo $file. "<br>";
            echo "<br>";
            echo public_path($file). "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
        }

        // Log::info("files: " . json_encode($files));
        // echo json_encode($files);
        die;
    }
}

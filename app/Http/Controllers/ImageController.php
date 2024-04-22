<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\UploadImageRequest;
use App\Services\ImageService;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use LogTrait;

    protected $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = $this->imageService->getAllImages();

        return response()->view("public.images.index", [
            'images' => $images
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("public.images.create", []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        // echo "thành công";
        // $this->logInfo("thành công");
        // die;
        // Store the file in storage\app\public folder
        // $file = $request->file('file');
        // $fileName = $file->getClientOriginalName();
        // $filePath = $file->store('uploads', 'public');
        // $this->logInfo("fileName: ". $fileName. " - ". $filePath);
        // $path = $request->file('file')->store('avatars');
        $result = $this->imageService->uploadImage($request);
        
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

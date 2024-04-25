<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ImageService;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    use LogTrait;

    protected $categoryService;
    protected $imageService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->imageService = new ImageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->categoryService->getAllCategories($request);

        $page = $data['page'];

        $paginatedData = new LengthAwarePaginator(
            $data['content'],
            $page['totalElements'],
            $page['size'],
            $page['number'] + 1,
            ['path' => $request->url()]
        );

        return response()->view('public.categories.index', [
            'categories' => $paginatedData,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images = $this->imageService->getAllImages();

        return response()->view('public.categories.create', [
            'images' => $images,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

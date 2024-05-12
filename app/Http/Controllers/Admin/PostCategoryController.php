<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Category\StorePostCategoryRequest;
use App\Http\Requests\Post\Category\UpdatePostCategoryRequest;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use App\Traits\LogTrait;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    use LogTrait;
    protected $postCategoryService;

    public function __construct()
    {
        $this->postCategoryService = new PostCategoryService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.postcategory.index', [
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.postcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostCategoryRequest $request)
    {
        $data = $request->all();
        $status = $this->postCategoryService->createPostCategory($data);
        if ($status) {
            request()->session()->flash('success', 'Post Category added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('postCategories.index');
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
        $postCategory = $this->postCategoryService->getPostCategoryById($id);
        return response()->view('admin.postcategory.edit', [
            'postCategory' => $postCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostCategoryRequest $request, $id)
    {
        $data = $request->all();
        $status = $this->postCategoryService->updatePostCategory($id, $data);
        if ($status) {
            request()->session()->flash('success', 'Post Category updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('postCategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->postCategoryService->softDeletePostCategory($id);

        if ($status) {
            request()->session()->flash('success', 'Post Category has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting Post Category');
        }
        return redirect()->route('postCategories.index');
    }

    public function getPostCategories()
    {
        $this->logInfo(request()->all());

        $data = $this->postCategoryService->getAllPostCategories();

        $postCategories = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $postCategories
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $postCategories
            ]
        );
    }
}

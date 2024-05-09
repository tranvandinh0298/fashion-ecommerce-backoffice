<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use LogTrait;
    protected $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentCategories = $this->getAllParentCategories();

        return response()->view("admin.category.index", [
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = $this->getAllParentCategories();

        return response()->view('admin.category.create', [
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        $status = $this->categoryService->createCategory($data);

        if ($status) {
            request()->session()->flash('success', 'Category added successfully');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('categories.index');
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
        $category = $this->categoryService->getCategoryById($id);

        $parentCategories = $this->getAllParentCategories();

        return response()->view('admin.category.edit', [
            'category' =>  $category,
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->all();
        $status = $this->categoryService->updateCategory($id, $data);

        if ($status) {
            request()->session()->flash('success', 'Category updated successfully');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->categoryService->softDeleteCategory($id);

        if ($status) {
            request()->session()->flash('success', 'Category has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting category');
        }
        return redirect()->route('categories.index');
    }

    public function getChildParentByParentCategoryId(Request $request)
    {
        $child_cat = Category::getChildByParentID($request->id);
        $childCategories = $this->getAllCategoriesWithoutPagination([
            'filters' => [
                ''
            ]
        ]);
        return response()->json(['status' => true, 'msg' => '', 'childCategories' => $childCategories]);
    }

    public function getCategories()
    {
        $this->logInfo(request()->all());

        $data = $this->categoryService->getAllCategories();

        $banners = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $banners
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $banners
            ]
        );
    }

    protected function getAllParentCategories()
    {
        $requestData = [
            'filters' => [
                [
                    "key" => "isParent",
                    "operator" => strtoupper("equal"),
                    "fieldType" => strtoupper("integer"),
                    "value" => 1
                ]
            ]
        ];

        return $this->getAllCategoriesWithoutPagination($requestData);
    }

    protected function getAllCategoriesWithoutPagination($requestData)
    {
        return $this->categoryService->getAllCategoriesWithoutPagination($requestData);
    }
}

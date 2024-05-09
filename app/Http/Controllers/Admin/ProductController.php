<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Traits\LogTrait;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use LogTrait;
    protected $productService;
    protected $categoryService;
    protected $brandService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.product.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategoriesWithoutPagination(
            [
                'filters' => [
                    [
                        'key' => 'isParent',
                        'operator' => 'EQUAL',
                        'fieldType' => 'INTEGER',
                        'value' => 1
                    ],
                    [
                        'key' => 'status',
                        'operator' => 'EQUAL',
                        'fieldType' => 'STRING',
                        'value' => 'active'
                    ]
                ]
            ]
        );
        $brands = $this->brandService->getAllBrandsWithoutPagination(
            [
                'filters' => [
                    [
                        'key' => 'status',
                        'operator' => 'EQUAL',
                        'fieldType' => 'STRING',
                        'value' => 'active'
                    ]
                ]
            ]
        );

        return response()->view('admin.product.create', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();

        $status = $this->productService->createProduct($data);
        if ($status) {
            request()->session()->flash('success', 'Product added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('products.index');
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
        $brands = $this->brandService->getAllBrandsWithoutPagination(['filters' => []]);

        $product = $this->productService->getProductById($id);

        $categories = $this->brandService->getAllBrandsWithoutPagination([
            'filters' => [
                [
                    'key' => 'isParent',
                    'operator' => 'EQUAL',
                    'fieldType' => 'INTEGER',
                    'value' => 1
                ]
            ]
        ]);

        // $items = Product::where('id', $id)->get();
        // return $items;
        return response()->view(
            'admin.product.edit',
            [
                'product' => $product,
                'brands' => $brands,
                'categories' => $categories,
                // 'items' => $items
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->all();

        $status = $this->productService->updateProduct($id, $data);

        if ($status) {
            request()->session()->flash('success', 'Product updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->productService->softDeleteProduct($id);

        if ($status) {
            request()->session()->flash('success', 'Product has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting product');
        }
        return redirect()->route('products.index');
    }

    public function getProducts()
    {
        $this->logInfo(request()->all());

        $data = $this->productService->getAllProducts();

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
}

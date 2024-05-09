<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Services\BrandService;
use App\Traits\LogTrait;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use LogTrait;
    protected $brandService;

    public function __construct()
    {
        $this->brandService = new BrandService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.brand.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->all();

        $status = $this->brandService->createBrand($data);

        if ($status) {
            request()->session()->flash('success', 'Brand created successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('brands.index');
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
        $brand = $this->brandService->getBrandById($id);

        return response()->view('admin.brand.edit', [
            'brand' => $brand
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $data = $request->all();

        $status = $this->brandService->updateBrand($id, $data);
        if ($status) {
            request()->session()->flash('success', 'Brand updated successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->brandService->softDeleteBrand($id);

        if ($status) {
            request()->session()->flash('success', 'Brand has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting brand');
        }
        return redirect()->route('brands.index');
    }

    public function getBrands()
    {
        $this->logInfo(request()->all());

        $data = $this->brandService->getAllBrands();

        $brands = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $brands
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $brands
            ]
        );
    }
}

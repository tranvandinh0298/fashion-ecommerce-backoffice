<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\BannerService;
use App\Traits\DisplayHtmlTrait;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    use LogTrait;
    protected $bannerService;

    public function __construct()
    {
        $this->bannerService = new BannerService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->all();

        $status = $this->bannerService->createBanner($data);

        if ($status) {
            request()->session()->flash('success', 'Banner has been added successfully');
        } else {
            request()->session()->flash('error', 'Error occurred while adding banner');
        }
        return redirect()->route('banners.index');
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
        $banner = $this->bannerService->getBannerById($id);

        return response()->view('admin.banner.edit', [
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, int $id)
    {
        $data = $request->all();

        $status = $this->bannerService->updateBanner($id, $data);

        if ($status) {
            request()->session()->flash('success', 'Banner has been updated successfully');
        } else {
            request()->session()->flash('error', 'Error occurred while updating banner');
        }
        return redirect()->route('banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->bannerService->softDeleteBanner($id);

        if ($status) {
            request()->session()->flash('success', 'Banner has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting banner');
        }
        return redirect()->route('banners.index');
    }

    public function getBanners()
    {
        $this->logInfo(request()->all());

        $data = $this->bannerService->getAllBanners();

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

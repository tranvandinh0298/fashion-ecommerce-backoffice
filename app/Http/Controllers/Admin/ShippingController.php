<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\StoreShippingRequest;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Coupon;
use App\Services\ShippingService;
use App\Traits\LogTrait;

class ShippingController extends Controller
{
    use LogTrait;
    protected $shippingService;

    public function __construct()
    {
        $this->shippingService = new ShippingService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $shipping = Shipping::orderBy('id', 'DESC')->paginate(10);


        return response()->view('admin.shipping.index', [
            // 'shippings' => $shipping
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShippingRequest $request)
    {
        $data = $request->all();
        $status = $this->shippingService->createShipping($data);
        if ($status) {
            request()->session()->flash('success', 'Shipping created successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('shippings.index');
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
        $shipping = $this->shippingService->getShippingById($id);
        return response()->view('admin.shipping.edit', [
            'shipping' => $shipping
        ]);
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
        $data = $request->all();
        $status = $this->shippingService->updateShipping($id, $data);
        if ($status) {
            request()->session()->flash('success', 'Shipping updated');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('shippings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->shippingService->softDeleteShipping($id);
        if ($status) {
            request()->session()->flash('success', 'Shnipping has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting shipping');
        }
        return redirect()->route('shippings.index');
    }

    public function getShippings()
    {
        $this->logInfo(request()->all());

        $data = $this->shippingService->getAllShippings();

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Services\CouponService;
use App\Traits\LogTrait;

class CouponController extends Controller
{
    use LogTrait;
    protected $couponService;

    public function __construct()
    {
        $this->couponService = new CouponService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $coupon = Coupon::orderBy('id', 'DESC')->paginate('10');
        return response()->view('admin.coupon.index', [
            // 'coupons', $coupon
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {
        $data = $request->all();
        $status = $this->couponService->createCoupon($data);
        if ($status) {
            request()->session()->flash('success', 'Coupon added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = $this->couponService->getCouponById($id);

        return response()->view('admin.coupon.edit', [
            'coupon' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        $data = $request->all();

        $status = $this->couponService->updateCoupon($id, $data);

        if ($status) {
            request()->session()->flash('success', 'Coupon updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->couponService->softDeleteCoupon($id);

        if ($status) {
            request()->session()->flash('success', 'Coupon has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting coupon');
        }
        return redirect()->route('coupons.index');
    }

    public function couponStore(Request $request)
    {
        // return $request->all();
        $coupon = Coupon::where('code', $request->code)->first();
        // dd($coupon);
        if (!$coupon) {
            request()->session()->flash('error', 'Invalid coupon code, Please try again');
            return back();
        }
        if ($coupon) {
            $total_price = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->sum('price');
            // dd($total_price);
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);
            request()->session()->flash('success', 'Coupon successfully applied');
            return redirect()->back();
        }
    }

    public function getCoupons()
    {
        $this->logInfo(request()->all());

        $data = $this->couponService->getAllCoupons();

        $coupons = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $coupons
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $coupons
            ]
        );
    }
}

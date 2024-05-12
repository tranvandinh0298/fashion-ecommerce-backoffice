<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Services\ReviewService;
use App\Traits\LogTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use LogTrait;
    protected $reviewService;

    public function __construct()
    {
        $this->reviewService = new ReviewService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.review.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = $this->reviewService->getReviewById($id);
        return response()->view('admin.review.edit', [
            'review' => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        $data = $request->all();
        $status = $this->reviewService->updateReview($id, $data);

        if ($status) {
            request()->session()->flash('success', 'Review updated');
        } else {
            request()->session()->flash('error', 'Something went wrong! Please try again!!');
        }

        return redirect()->route('reviews.index');
    }

    public function getReviews()
    {
        $this->logInfo(request()->all());

        $data = $this->reviewService->getAllReviews();

        $reviews = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $reviews
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $reviews
            ]
        );
    }
}

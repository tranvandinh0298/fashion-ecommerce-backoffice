<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Tag\StorePostTagRequest;
use App\Http\Requests\Post\Tag\UpdatePostTagRequest;
use Illuminate\Http\Request;
use App\Models\PostTag;
use App\Services\PostTagService;
use App\Traits\LogTrait;
use Illuminate\Support\Str;

class PostTagController extends Controller
{
    use LogTrait;
    protected $postTagService;

    public function __construct()
    {
        $this->postTagService = new PostTagService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $postTag = PostTag::orderBy('id', 'DESC')->paginate(10);
        return response()->view('admin.posttag.index', [
            // 'postTags' => $postTag
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.posttag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostTagRequest $request)
    {
        $data = $request->all();
        $status = $this->postTagService->createPostTag($data);
        if ($status) {
            request()->session()->flash('success', 'Post Tag added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('postTags.index');
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
        $postTag = $this->postTagService->getPostTagById($id);
        return response()->view('admin.posttag.edit', [
            'postTag' => $postTag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostTagRequest $request, $id)
    {
        $data = $request->all();
        $status = $this->postTagService->updatePostTag($id, $data);
        if ($status) {
            request()->session()->flash('success', 'Post Tag updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('postTags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->postTagService->softDeletePostTag($id);

        if ($status) {
            request()->session()->flash('success', 'Post Tag has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting Post Tag');
        }
        return redirect()->route('postTags.index');
    }

    public function getPostTags()
    {
        $this->logInfo(request()->all());

        $data = $this->postTagService->getAllPostTags();

        $postTags = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $postTags
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $postTags
            ]
        );
    }
}

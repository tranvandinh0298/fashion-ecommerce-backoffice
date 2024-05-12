<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Services\PostTagService;
use App\Traits\LogTrait;

class PostController extends Controller
{
    use LogTrait;
    protected $postService;
    protected $postTagService;
    protected $postCategoryService;

    public function __construct()
    {
        $this->postService = new PostService();
        $this->postTagService = new PostTagService();
        $this->postCategoryService = new PostCategoryService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('admin.post.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postCategories = $this->postCategoryService->getAllPostCategoriesWithoutPagination([
            'filters' => []
        ]);
        $postTags = $this->postTagService->getAllPostTagsWithoutPagination([
            'filters' => []
        ]);
        return response()->view('admin.post.create', [
            'postCategories' => $postCategories, 
            'postTags' => $postTags
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
        $data = $request->all();

        $status = $this->postService->createPost($data);
        if ($status) {
            request()->session()->flash('success', 'Post added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('posts.index');
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
        $post = $this->postService->getPostById($id);
        $postCategories = $this->postCategoryService->getAllPostCategoriesWithoutPagination([
            'filters' => []
        ]);
        $postTags = $this->postTagService->getAllPostTagsWithoutPagination([
            'filters' => []
        ]);
        return response()->view('admin.post.edit', [
            'postCategories' => $postCategories,
            'postTags' => $postTags,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $data = $request->all();
        $status = $this->postService->updatePost($id, $data);
        if ($status) {
            request()->session()->flash('success', 'Post updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->postService->softDeletePost($id);

        if ($status) {
            request()->session()->flash('success', 'Post has been deleted successfully.');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting Post');
        }
        return redirect()->route('posts.index');
    }

    public function getPosts()
    {
        $this->logInfo(request()->all());

        $data = $this->postService->getAllPosts();

        $posts = collect($data['content']);

        $page = $data['page'];

        $this->logInfo([
            'draw' => request()->get("draw"),
            'recordsTotal' => $page['totalElements'],
            'recordsFiltered' => $page['totalElements'],
            'data' => $posts
        ]);

        return response()->json(
            [
                'draw' => request()->get("draw"),
                'recordsTotal' => $page['totalElements'],
                'recordsFiltered' => $page['totalElements'],
                'data' => $posts
            ]
        );
    }
}

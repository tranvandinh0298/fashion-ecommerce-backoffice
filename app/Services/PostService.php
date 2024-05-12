<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class PostService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function getAllPosts()
    {
        $requestData = $this->getFilterData();

        $data = $this->postRepository->getAllPosts($requestData);

        if (empty($data)) {
            $data = [
                "content" => [],
                "page" => [
                    "size" => $requestData['size'],
                    "totalElements" => 0,
                    "totalPages" => 0,
                    "number" => 0
                ],
            ];
        }

        $content = $data['content'];
        $data['content'] = $this->convertListOfPostsToHTML($content);

        return $data;
    }

    public function getAllPostsWithoutPagination($requestData)
    {
        $data = $this->postRepository->getAllPostsWithoutPagination($requestData);

        $data = $this->convertListOfPostDTOs($data);

        return $data;
    }

    public function getPostById($postId)
    {
        $data = $this->postRepository->getPostById($postId);

        $data = $this->convertListOfPostDTOs($data);

        return $data;
    }

    public function createPost(array $insertData)
    {
        $data = $this->postRepository->createPost($insertData);

        return $data;
    }

    public function updatePost(int $postId, array $updateData)
    {
        $data = $this->postRepository->updatePost($postId, $updateData);

        return $data;
    }

    public function softDeletePost(int $postId)
    {
        $data = $this->postRepository->softDeletePost($postId);

        return $data;
    }

    public function deletePost(int $id): bool
    {
        return true;
    }

    protected function convertListOfPostDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($post) {
                return $this->convertPostDTOtoPost($post);
            });
            return $data;
        }
    }

    protected function convertPostDTOtoPost($postDTO)
    {
        return [
            'postId' => $postDTO['postId'],
            'title' => $postDTO['title'],
            'slug' => $postDTO['slug'],
            'summary' => $postDTO['summary'],
            'description' => $postDTO['description'],
            'quote' => $postDTO['quote'],
            'photo' => url($postDTO['photo']),
            'tags' => explode(",", $postDTO['tags']),
            'postCategory' => $postDTO['postCategoryDTO'],
            'postTag' => $postDTO['postTagDTO'],
            'user' => $postDTO['userDTO'],
            'status' => $postDTO['status'],
        ];
    }

    protected function convertListOfPostsToHTML($posts) {
        if (!empty($posts)) {
            $data = collect($posts)->map(function ($post) {
                return $this->convertPostToHTML($this->convertPostDTOtoPost($post));
            });
            return $data;
        }
    }

    protected function convertPostToHTML($post) {
        $post['photo'] = $this->displayPhoto($post['photo']);
        $post['status'] = $this->displayStatus($post['status']);
        $post['action'] = $this->displayAction($post['postId'], 'posts');

        return $post;
    }
}

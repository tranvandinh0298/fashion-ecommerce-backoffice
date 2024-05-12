<?php

namespace App\Services;

use App\Exceptions\RestException;
use App\Models\PostTag;
use App\Repositories\PostTagRepository;
use App\Traits\DisplayHtmlTrait;
use App\Traits\LogTrait;
use App\Traits\ProcessingDataTrait;
use App\Traits\RequestToCoreTrait;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class PostTagService
{
    use ProcessingDataTrait;
    use DisplayHtmlTrait;

    protected $postTagRepository;

    public function __construct()
    {
        $this->postTagRepository = new PostTagRepository();
    }

    public function getAllPostTags()
    {
        $requestData = $this->getFilterData();

        $data = $this->postTagRepository->getAllPostTags($requestData);

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
        $data['content'] = $this->convertListOfPostTagsToHTML($content);

        return $data;
    }

    public function getAllPostTagsWithoutPagination($requestData)
    {
        $data = $this->postTagRepository->getAllPostTagsWithoutPagination($requestData);

        $data = $this->convertListOfPostTagDTOs($data);

        return $data;
    }

    public function getPostTagById($postTagId)
    {
        $data = $this->postTagRepository->getPostTagById($postTagId);

        $data = $this->convertPostTagDTOtoPostTag($data);

        return $data;
    }

    public function createPostTag(array $insertData)
    {
        $data = $this->postTagRepository->createPostTag($insertData);

        return $data;
    }

    public function updatePostTag(int $postTagId, array $updateData)
    {
        $data = $this->postTagRepository->updatePostTag($postTagId, $updateData);

        return $data;
    }

    public function softDeletePostTag(int $postTagId)
    {
        $data = $this->postTagRepository->softDeletePostTag($postTagId);

        return $data;
    }

    public function deletePostTag(int $id): bool
    {
        return true;
    }

    protected function convertListOfPostTagDTOs($content)
    {
        if (!empty($content)) {
            $data = collect($content)->map(function ($postTag) {
                return $this->convertPostTagDTOtoPostTag($postTag);
            });
            return $data;
        }
    }

    protected function convertPostTagDTOtoPostTag($postTagDTO)
    {
        return [
            'postTagId' => $postTagDTO['postTagId'],
            'title' => $postTagDTO['title'],
            'slug' => $postTagDTO['slug'],
            'status' => $postTagDTO['status'],
        ];
    }

    protected function convertListOfPostTagsToHTML($postTags) {
        if (!empty($postTags)) {
            $data = collect($postTags)->map(function ($postTag) {
                return $this->convertPostTagToHTML($this->convertPostTagDTOtoPostTag($postTag));
            });
            return $data;
        }
    }

    protected function convertPostTagToHTML($postTag) {
        $postTag['status'] = $this->displayStatus($postTag['status']);
        $postTag['action'] = $this->displayAction($postTag['postTagId'], 'postTags');

        return $postTag;
    }
}

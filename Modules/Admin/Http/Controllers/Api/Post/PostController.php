<?php

namespace Modules\Admin\Http\Controllers\Api\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Post;
use Modules\Admin\Http\Requests\Post\CreatePostRequest;
use Modules\Admin\Http\Requests\Post\UpdatePostRequest;
use Modules\Admin\Repositories\PostRepository;
use Illuminate\Routing\Controller;
use Modules\Admin\Transformers\PostTransformer;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class PostController extends ApiController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(Authentication $auth, PostRepository $post)
    {
        parent::__construct($auth);

        $this->postRepository = $post;
    }


    public function index(Request $request)
    {
        return PostTransformer::collection($this->postRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return PostTransformer::collection($this->postRepository->newQueryBuilder()->get());
    }


    public function store(CreatePostRequest $request)
    {
        $this->postRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::post.message.create success'),
        ]);
    }


    public function find(Post $post)
    {
        return new  PostTransformer($post);
    }

    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->postRepository->update($post, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::post.message.update success'),
        ]);
    }

    public function destroy(Post $post)
    {
        $this->postRepository->destroy($post);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::post.message.delete success'),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexFilterRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    private $repository;

    public function __construct(PostRepositoryInterface $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
        $this->repository = $userRepository;
    }

    public function index(IndexFilterRequest $request)
    {
        return $this->repository->postFilter($request);
    }

    public function store(StorePostRequest $request)
    {
        return $this->repository->createPost($request);
    }

    public function show($id)
    {
        return $this->repository->showPostById($id);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        return $this->repository->updatePostById($id, $request);
    }

    public function destroy($id)
    {
        return $this->repository->deletePostById($id);
    }
}

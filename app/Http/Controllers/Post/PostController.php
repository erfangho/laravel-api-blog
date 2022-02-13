<?php

namespace App\Http\Controllers\Post;


use App\Http\Controllers\Controller;
use App\Http\Requests\IndexFilterRequest;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Carbon\Carbon;
use App\Models\Repositories\PostRepositoryInterface;
use Symfony\Component\Console\Input\Input;

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


    public function store(PostRequest $request)
    {
        return $this->repository->createPost($request);
    }


    public function show($id)
    {
        return $this->repository->showPostById($id);
    }


    public function update(PostRequest $request, $id)
    {
        return $this->repository->updatePostById($id, $request);
    }


    public function destroy(Request $request, $id)
    {
        return $this->repository->deletePostById($id);
    }
}

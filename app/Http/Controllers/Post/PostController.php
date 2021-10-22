<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Support\Facades\Validator;
use App\Repository\Post\PostRepository;
use App\Services\Post\PostCreator;
use App\Services\Post\PostDeleter;
use App\Services\Post\PostUpdater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /** 
     * @var PostRepository
    */
    private $repository;

    /**
     * @var PostCreator
     */
    private $postCreatorService;

    /**
     * @var PostUpdater
     */
    private $postUpdaterService;

    /**
     * @var PostDeleter
     */
    private $postDeleterService;

    /** 
     * PostController Constructor.
     * @param PostRepository $repository
     * @param PostCreator $postCreatorService
     * @param PostUpdater $postUpdaterService
     * @param PostDeleter $postDeleterService
    */
    public function __construct(PostRepository $repository, PostCreator $postCreatorService, PostUpdater $postUpdaterService, PostDeleter $postDeleterService) {
        $this->repository = $repository;
        $this->postCreatorService = $postCreatorService;
        $this->postUpdaterService = $postUpdaterService;
        $this->postDeleterService = $postDeleterService;
    }

    /** 
     * @return LengthAwarePaginator
    */
    public function index() {
        $keyword = request()->query('keyword');
        $limit = (int) request()->query('limit', 15);

        return $this->repository->findByTitle($keyword, $limit);
    }

    /** 
     * @param Request $request
     * @return Post|JsonResponse
     * @throws ReflectionException
    */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:1000',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $post = $this->postCreatorService->create($request->all());

        return $post;
    }

    /** 
     * @param Request $request
     * @return JsonResponse
     * @throws ReflectionException
    */
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:1000',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $post = Post::find($request->route('id'));

        if(empty ($post)){
            return response()->json([
                    'success' => false,
                    'message' => 'Record with ID not found!',
            ], 404);
        }

        Gate::authorize('update', $post);

        $post->fill($request->all());

        $this->postUpdaterService->update($post);

        return $post;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(empty ($post)){
            return response()->json([
                'success' => false,
                'message' => 'Record with ID not found!',
            ], 404);
        }

        Gate::authorize('update', $post);

        $this->postDeleterService->delete($post);

        return $post;
    }
}

<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class CommentController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(app(CommentRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(app(CommentRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json(app(CommentRepository::class)->show($comment), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        return response()->json(app(CommentRepository::class)->update($request, $comment->id),
            HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Comment $comment
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment): JsonResponse
    {
        return response()->json(app(CommentRepository::class)->delete($comment), HttpStatus::HTTP_NO_CONTENT);
    }
}

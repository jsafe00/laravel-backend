<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\Posts\CreateUpdatePostFormRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        $posts = Post::all();

        return PostResource::collection($posts);
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Posts\CreateUpdatePostFormRequest $request
     *
     * @return \App\Http\Resources\PostResource
     */
    public function create(CreateUpdatePostFormRequest $request): PostResource
    {
        $post = Post::query()->create($request->validated());

        return new PostResource($post);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Posts\CreateUpdatePostFormRequest  $request
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\PostResource
     */
    public function update(CreateUpdatePostFormRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json([
            'messages' => [
                $post->title . ' has been deleted',
            ]
        ]);
    }
}

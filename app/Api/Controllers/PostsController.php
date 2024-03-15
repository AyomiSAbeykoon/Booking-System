<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Api\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Responses\ApiResponse;
use Throwable;
use Exception;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $limit = 10;

            $posts = Post::paginate($limit);
            return ApiResponse::success($posts);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }
    public function searchPosts($keyword)
    {
        try {
            $limit = 10;
            $posts = Post::where('title', 'LIKE', '%' . $keyword . '%')->paginate($limit);
            return ApiResponse::success($posts);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->published_date = $request->published_date;
            $post->status = $request->status;
            $post->save();

            return ApiResponse::success($post);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = Post::where('id', $id)->first();

            return ApiResponse::success($post);
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            $post = Post::find($id);

            if ($post) {

                $post->update([
                    'title' =>  $request->title,
                    'body' => $request->body,
                    'published_date' => $request->published_date,
                    'status' => $request->status
                ]);

                return ApiResponse::success($post);
            }
            return ApiResponse::notFound();
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $post = Post::find($id);
            if ($post) {
                $post->delete();
                return ApiResponse::success($post);
            }
            return ApiResponse::notFound();
        } catch (Throwable $th) {
            throw $th;
            return ApiResponse::exception();
        }
    }
}

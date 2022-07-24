<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $posts = PostResource::collection(Post::get());
        $msg = ["ok"];
        return response($posts,200,$msg);

    }

    public function show($id){
        $posts = Post::find($id) ;
        if ($posts) {
            return $this->apiResponse(new PostResource($posts), 'ok', 200);
        }
        return $this->apiResponse(null,'The post is not found', 404);

    }

    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required'
        ]);
        if ($validation)
        $posts = Post::create($request->all()) ;
        if ($posts) {
            return $this->apiResponse(new PostResource($posts), 'ok', 201);
        }
        return $this->apiResponse(null,'The post is not saved', 400);

    }
}

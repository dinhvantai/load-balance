<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Api\ApiController;

class PostController extends ApiController
{
    protected $apiProvider = 'users';

    public function  __construct()
    {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectCategory = ['id', 'name', 'slug', 'parent_id'];

        $posts = Post::with(['category' => function($query) use ($selectCategory){
            $query->select($selectCategory)->with(['parentCategory' => function($query) use ($selectCategory){
                $query->select($selectCategory);
            }]);
        }])
        ->orderBy('id', 'desc')->get();

        return $this->response($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data = $request->all();
        $data['slug'] = str_slug($request->slug);

        if ($post = Post::create($data)) {
            return $this->response([
                'message' => trans('message.add_success'),
                'data' => $post,
            ]);
        }

        return $this->response(['message' => trans('message.add_failed')], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->response($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->slug = str_slug($request->slug);

        if ($post->save()) {
            return $this->response([
                'message' => trans('message.edit_success'),
                'data' => $post,
            ]);
        }
    
        return $this->response(['message' => trans('message.edit_failed')], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $image = $post->image;
        if ($post->delete()) {
            \App\Helpers\Helper::deleteFile($image);

            return $this->response(['message' => trans('message.delete_success')]);
        }

        return $this->response(['message' => trans('message.delete_failed')], 401);
    }
}

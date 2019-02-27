<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
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
        $categories = Category::with(['childrenCategories' => function($query){
            $query->orderBy('prioty', 'desc');
        }])
        ->whereNull('parent_id')->orWhere('parent_id', 0)
        ->orderBy('prioty', 'desc')->get();

        return $this->response($categories);
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
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = str_slug($request->slug);

        if (Category::create($data)) {
            return $this->response(['message' => trans('message.add_success')]);
        }

        return $this->response(['message' => trans('message.add_failed')], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->slug = str_slug($request->slug);

        if ($category->save()) {
            return $this->response(['message' => trans('message.edit_success')]);
        }
    
        return $this->response(['message' => trans('message.edit_failed')], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!$category->parent_id && $category->childrenCategories()->count()) {
            return $this->response(['message' => trans('message.delete_children_before')], 401);
        }
        
        if ($category->posts()->count() || $category->products()->count()) {
            return $this->response(['message' => trans('message.exits_product_or_post')], 401);
        }

        if ($category->delete()) {
            return $this->response(['message' => trans('message.delete_success')]);
        }

        return $this->response(['message' => trans('message.delete_failed')], 401);
    }
}

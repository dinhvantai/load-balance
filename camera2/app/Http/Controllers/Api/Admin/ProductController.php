<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Api\ApiController;

class ProductController extends ApiController
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

        $products = Product::with(['category' => function($query) use ($selectCategory){
            $query->select($selectCategory)->with(['parentCategory' => function($query) use ($selectCategory){
                $query->select($selectCategory);
            }]);
        }])
        ->orderBy('id', 'desc')->get();
        
        return $this->response($products);
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
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = str_slug($request->slug);

        if ($product = Product::create($data)) {
            return $this->response([
                'message' => trans('message.add_success'),
                'data' => $product,
            ]);
        }

        return $this->response(['message' => trans('message.add_failed')], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->response($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->slug = str_slug($request->slug);

        if ($product->save()) {
            return $this->response([
                'message' => trans('message.edit_success'),
                'data' => $product,
            ]);
        }
    
        return $this->response(['message' => trans('message.edit_failed')], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $image = $product->image;
        if ($product->delete()) {
            \App\Helpers\Helper::deleteFile($image);

            return $this->response(['message' => trans('message.delete_success')]);
        }

        return $this->response(['message' => trans('message.delete_failed')], 401);
    }
}

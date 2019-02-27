<?php

namespace App\Http\Controllers\User;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $homeCategories = Category::with(['childrenCategories' => function($query){
                $query->where('status', Category::STATUS_SHOW)
                    ->orderBy('prioty', 'desc')->orderBy('id');
            }])
            ->where('type', Category::TYPE_PRODUCT)
            ->where('status', Category::STATUS_SHOW)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->orderBy('prioty', 'desc')->orderBy('id')
            ->get();

        foreach ($homeCategories as $key => $category) {
            $categoryIds = array_merge(
                [$category->id], 
                $category->childrenCategories()->pluck('id')->toArray()
            );
            
            $homeCategories[$key]->products = Product::where('status', Product::STATUS_SHOW)                
                ->whereIn('category_id', $categoryIds)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->take(8)->get();
        }

        return view('user.index', compact(['homeCategories']));
    }

    public function categoryParent($parent)
    {
        $category = Category::with('childrenCategories')
            ->where('status', Category::STATUS_SHOW)->where('slug', $parent)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->first();

        if (!$category) {
            return redirect('/');
        }

        $categoryIds = array_merge(
            [$category->id], 
            $category->childrenCategories()->pluck('id')->toArray()
        );

        if ($category->type === Category::TYPE_PRODUCT) {
            $products = Product::where('status', Product::STATUS_SHOW)                
                ->whereIn('category_id', $categoryIds)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->paginate(12);

            return view('user.category.parent-product', compact(['category', 'products']));
        }

        if ($category->type === Category::TYPE_POST) {
            $countPost = Post::whereIn('category_id', $categoryIds)->count();

            if ($countPost === 1) {
                $post = Post::whereIn('category_id', $categoryIds)->first();
                    
                return view('user.category.one-post', compact(['category', 'post']));
            }

            $categories = Category::with('parentCategory')
                ->with(['posts' => function($query){
                    $query->where('status', Post::STATUS_SHOW)
                        ->orderBy('id', 'desc')->take(6);
                }])
                ->where('status', Category::STATUS_SHOW)
                ->whereIn('id', $categoryIds)
                ->orderBy('prioty', 'desc')->get();

            return view('user.category.parent-post', compact(['category', 'categories']));
        }

        return redirect('/');
    }

    public function search(Request $request) {
        $key = $request->key;

        $products = Product::where('status', Product::STATUS_SHOW)                
                ->where('name', 'like', "%{$key}%")
                ->where('description', 'like', "%{$key}%")
                ->where('detail', 'like', "%{$key}%")
                ->where('guide', 'like', "%{$key}%")
                ->where('guide', 'like', "%{$key}%")
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->paginate(16);

        return view('user.search.search', compact('products'));
    }

    public function categoryChildren($parent, $children)
    {
        $categoryParent = Category::with('childrenCategories')
            ->where('status', Category::STATUS_SHOW)->where('slug', $parent)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->first();

        if (!$categoryParent) {
            return redirect('/');
        }
        
        $category = Category::where('status', Category::STATUS_SHOW)
            ->where('parent_id', $categoryParent->id)
            ->where('slug', $children)->first();

        if (!$category) {
            return redirect()->route('user.category.parent', [$categoryParent->slug]);
        }

        if ($categoryParent->type === Category::TYPE_PRODUCT) {
            $products = Product::where('status', Product::STATUS_SHOW)                
                ->where('category_id', $category->id)
                ->orderBy('prioty', 'desc')->orderBy('id', 'desc')
                ->paginate(16);

            return view('user.category.children-product', compact(['category', 'products', 'categoryParent']));
        }

        if ($categoryParent->type === Category::TYPE_POST) {
            $posts = Post::where('status', Post::STATUS_SHOW)
                ->where('category_id', $category->id)
                ->orderBy('id', 'desc')
                ->paginate(10);

            return view('user.category.children-post', compact(['category', 'posts', 'categoryParent']));
        }

        return redirect('/');
    }

    public function detailProduct($slug)
    {
        $data['product'] = Product::with('category.parentCategory')
            ->where('status', Product::STATUS_SHOW)
            ->where('slug', $slug)->first();
        
        if(!$data['product']) {
            return redirect('/');
        }

        $data['product']->total_views += 1;
        $data['product']->save();

        if ($data['product']->category->parentCategory) {
            $parentCategory = $data['product']->category->parentCategory;
            $data['parentCategory'] = $parentCategory;
            $categoryIds =  [$data['product']->category->id];
        } else {
            $data['parentCategory'] = $data['product']->category;
            $categories = $data['product']->category->childrenCategories()->pluck('id')->toArray();
            $categoryIds = array_merge([$data['product']->category->id], $categories);
        }
        
        $data['productRelation'] = Product::where('status', Product::STATUS_SHOW)
            ->whereIn('category_id', $categoryIds)
            ->where('id', '<>', $data['product']->id)
            ->take(12)->get();

        return view('user.product.detail', compact(['data']));
    }

    public function detailPost($slug)
    {
        $data['post'] = Post::with('category.parentCategory')
            ->where('status', Post::STATUS_SHOW)
            ->where('slug', $slug)->first();
        
        if(!$data['post']) {
            return redirect('/');
        }

        $data['post']->total_views += 1;
        $data['post']->save();

        $data['newer-news'] = Post::where('status', Post::STATUS_SHOW)
            ->where('created_at', '>', $data['post']->created_at)
            ->orderBy('id', 'desc')->take(10)->get();

        $data['older-news'] = Post::where('status', Post::STATUS_SHOW)
            ->where('created_at', '<', $data['post']->created_at)
            ->orderBy('id', 'desc')->take(10)->get();

        return view('user.post.detail', compact(['data']));
    }

    public function listPost()
    {
        $posts = Post::where('status', Post::STATUS_SHOW)
            ->paginate(12);

        return view('user.post.popular', compact(['posts']));
    }
}

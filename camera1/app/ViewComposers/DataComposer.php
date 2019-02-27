<?php

namespace App\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Post;
use App\Models\Extra;
use App\Models\Banner;

class DataComposer
{
	protected $menu;
    protected $category;
    protected $post;
    protected $extra;
    protected $banner;
    
    public function __construct(
    	Menu $menu,
        Category $category,
        Post $post,
        Extra $extra,
        Banner $banner
    ){
        $this->menu = $menu;
        $this->category = $category;
        $this->post = $post;
        $this->extra = $extra;
        $this->banner = $banner;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Schema::hasTable($this->menu->getTable())) {
            $menu['left'] = $this->menu
                ->where('position', Menu::POSITION_ON_TOP_LEFT)
                ->orderBy('prioty', 'desc')->get();
            
            $menu['right'] = $this->menu
                ->where('position', Menu::POSITION_ON_TOP_RIGHT)
                ->orderBy('prioty', 'desc')->get();

          
            $view->with('userMenu', $menu);
        }
        
        if (Schema::hasTable($this->category->getTable())) {
            $categories = $this->category->with(['childrenCategories' => function($query){
                    $query->where('status', Category::STATUS_SHOW)
                        ->orderBy('prioty', 'desc')->orderBy('id');
                }])
                ->where('type', Category::TYPE_PRODUCT)
                ->where('status', Category::STATUS_SHOW)
                ->whereNull('parent_id')->orWhere('parent_id', 0)
                ->orderBy('prioty', 'desc')->orderBy('id')
                ->get();

            $view->with('userCategories', $categories);

            $postCategories = $this->category->with(['childrenCategories' => function($query){
                $query->where('status', Category::STATUS_SHOW)
                    ->orderBy('prioty', 'desc')->orderBy('id');
            }])
            ->where('type', Category::TYPE_POST)
            ->where('status', Category::STATUS_SHOW)
            ->whereNull('parent_id')->orWhere('parent_id', 0)
            ->get();

            $view->with('userPostCategories', $postCategories);
        }

        if (Schema::hasTable($this->post->getTable())) {
            $posts = $this->post
                ->where('status', POST::STATUS_SHOW)
                ->orderBy('prioty', 'desc')
                ->orderBy('id', 'desc')
                ->take(3)->get();

            $view->with('userHotPosts', $posts);
        }

        if (Schema::hasTable($this->extra->getTable())) {
            $setups = $this->extra->where('position', Extra::POSITION_MAIN)->first();

            $view->with('userSetups', $setups);
        }

        if (Schema::hasTable($this->banner->getTable())) {
            $banner['ad'] = Banner::where('status', Banner::STATUS_SHOW)
                ->where('position', Banner::POSITION_AD)
                ->orderBy('id', 'desc')->get();
                
            $banner['partner'] = Banner::where('status', Banner::STATUS_SHOW)
                ->where('position', Banner::POSITION_PARTNER)
                ->get();

            $view->with('userBanners', $banner);
        }
    }
}

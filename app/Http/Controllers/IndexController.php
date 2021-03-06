<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Menu;
use App\Models\Portfolio;
use App\Models\Slider;
use App\Repositories\ArticlesRepo;
use App\Repositories\MenuRepo;
use App\Repositories\PortfolioRepo;
use App\Repositories\SliderRepo;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class IndexController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->s_rep = new SliderRepo(new Slider());
        $this->p_rep = new PortfolioRepo(new Portfolio());
        $this->a_rep = new ArticlesRepo(new Article());
        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->keywords = 'Pink rio';
        $this->meta_desc = 'Home page';
        $this->title = 'Pink Rio | A strong, powerful and multiporpose';
        $this->sort = 'desc';
        $portfolios = $this->getPortfolios(Config::get('settings.home_portfolio_count'), false);
        $content = view(env('THEME') . '.content')->with('portfolios', $portfolios )->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);
        $sliderItems = $this->getSliders();
        $slider = view(env('THEME') . '.slider')->with('sliders', $sliderItems )->render();
        $this->vars =  Arr::add( $this->vars, 'slider', $slider);
        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME') . '.indexBar')->with('articles', $articles )->render();

        return $this->renderOutput();
    }



    protected function getSliders()
    {
        $sliders =  $this->s_rep->get();
        if($sliders->isEmpty()) return false;
            $sliders->transform(function($item, $key){
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });
        //dd($sliders);
        return $sliders;
    }



    protected function getArticles()
    {
        $articles = $this->a_rep->get(['title', 'desc', 'created_at', 'img', 'alias'], Config::get('settings.home_articles_count'));

        return $articles;

    }
}

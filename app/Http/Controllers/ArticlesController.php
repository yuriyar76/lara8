<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Menu;
use App\Models\Portfolio;
use App\Repositories\ArticlesRepo;
use App\Repositories\MenuRepo;
use App\Repositories\PortfolioRepo;
use Arr;
use Illuminate\Http\Request;

class ArticlesController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->bar = 'right';
        $this->p_rep = new PortfolioRepo(new Portfolio());
        $this->a_rep = new ArticlesRepo(new Article());

        $this->template = env('THEME') . '.articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->keywords = 'Pink rio articles';
        $this->meta_desc = 'Articles page';
        $this->title = 'Pink Rio | Articles';
        $epilog = view(env('THEME') . '.epilog')->render();
        $this->vars =  Arr::add( $this->vars, 'epilog', $epilog);
        $articles = $this->getArticles();
        $content = view(env('THEME') . '.articles_content')->with('articles', $articles )->render();
        $this->bar = 'right';
        $this->vars =  Arr::add( $this->vars, 'content', $content);


        return $this->renderOutput();
    }

    public function getArticles($alias = false){
        $articles = $this->a_rep->get(['id','user_id', 'category_id', 'title', 'alias', 'img', 'desc', 'created_at'], false, true );
        if($articles){
           $articles->load('user', 'category', 'comment');   // подгрузка данных из связанных моделей
        }
        return $articles;
        //dd($articles);
    }

}

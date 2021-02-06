<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Portfolio;
use App\Repositories\ArticlesRepo;
use App\Repositories\CommentsRepo;
use App\Repositories\MenuRepo;
use App\Repositories\PortfolioRepo;
use Arr;
use Config;
use Illuminate\Http\Request;

class ArticlesController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->bar = 'right';
        $this->p_rep = new PortfolioRepo(new Portfolio());
        $this->a_rep = new ArticlesRepo(new Article());
        $this->c_rep = new CommentsRepo(new Comment());
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
        $this->bar = 'right';
        $epilog = view(env('THEME') . '.epilog')->render();
        $this->vars =  Arr::add( $this->vars, 'epilog', $epilog);
        $articles = $this->getArticles();
        $content = view(env('THEME') . '.articles_content')->with('articles', $articles )->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);
        $comments = $this->getComments(Config::get('settings.recent_comments'));
        $portfolios =  $this->getPortfolios(Config::get('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar')->with(['comments' => $comments,
            'portfolios' => $portfolios])->render();


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

    public function getPortfolios($take){
        $portfolios = $this->p_rep->get('*', $take);
        //dump($portfolios);
        return $portfolios;
        //dd($articles);
    }

    public function getComments($take){
        $comments = $this->c_rep->get('*', $take);
        if($comments){
            $comments->load('article','user');   // подгрузка данных из связанных моделей
        }
        return $comments;
    }
}

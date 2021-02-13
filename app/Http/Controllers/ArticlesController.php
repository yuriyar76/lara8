<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
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
    public function index($get_cat=false)
    {

        $this->bar = 'right';

        $articles = $this->getArticles($get_cat);

        $this->keywords = 'Pink rio articles';
        $this->meta_desc = 'Articles page';
        $this->title = 'Pink Rio | Articles';
        if ($get_cat){
             $this->keywords = $articles[0]->category->keywords;
             $this->meta_desc = $articles[0]->category->meta_desc;
             $this->title = $articles[0]->category->title;
         }
        $content = view(env('THEME') . '.articles_content')->with('articles', $articles )->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);
        $comments = $this->getComments(Config::get('settings.recent_comments'));
        $portfolios =  $this->getPortfolios(Config::get('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar')->with(['comments' => $comments,
            'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }

    public function getArticles($alias = false){
        $where = false;
        if ($alias){
            $id = Category::query()->select('id')->where('alias',$alias)->first()->id;
            $where = ['category_id', $id];
           // dump($id);
        }
        $this->sort = 'desc';
        $articles = $this->a_rep->get(['id','user_id', 'category_id', 'title', 'alias',
            'img', 'desc', 'created_at', 'keywords', 'meta_desc'], false, true, $where, $this->sort );
        if($articles){
           $articles->load('user', 'category', 'comment');   // подгрузка данных из связанных моделей
        }

        return $articles;
        //dd($articles);
    }
/*
    public function getPortfolios($take){
        $portfolios = $this->p_rep->get('*', $take);
        //dump($portfolios);
        return $portfolios;
      //dd($articles);
    } */

    public function getComments($take){
        $comments = $this->c_rep->get('*', $take);
        if($comments){
            $comments->load('article','user');   // подгрузка данных из связанных моделей
        }
        return $comments;
    }

    public function show($alias=false){

        $this->bar = 'right';

        $article = $this->a_rep->one($alias, ['comments'=>true]);  // с подгрузкой доп инфо для получения комментов
        $this->keywords = $article->keywords;
        $this->meta_desc =  $article->meta_desc;
        $this->title = $article->title;

        //dump($article->comment->groupBy('parent_id'));
        $content = view(env('THEME') . '.article_content')->with('article', $article )->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);

        $comments = $this->getComments(Config::get('settings.recent_comments'));
        $this->sort = 'desc';
        $portfolios =  $this->getPortfolios(Config::get('settings.recent_portfolios'),false);
        $this->contentRightBar = view(env('THEME') . '.articlesBar')->with(['comments' => $comments,
            'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }
}

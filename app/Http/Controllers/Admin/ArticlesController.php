<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteController;
use App\Models\Article;
use App\Repositories\ArticlesRepo;
use App\Repositories\CategoriesRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends AdminController
{

    public function __construct(ArticlesRepo $a_rep, CategoriesRepo $cat_rep)
    {
        parent::__construct($cat_rep);
        $this->a_rep = $a_rep;

        $this->template = env('THEME') . '.admin.articles';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $this->user = Auth::user();
        if(Gate::forUser($this->user)->denies('VIEW_ADMIN_ARTICLES')){
            abort(403);
        }
        $this->title = 'Панель администратора. Редактирование материала.';
        $articles = $this->getArticles();
        $this->content = view(env('THEME') . '.admin.articles_content')->with('articles', $articles)->render();
        return $this->renderOutput();
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * method save app\Policies\ArticlePolicy.php
     */
    public function create()
    {
        $this->user = Auth::user();
        if(Gate::forUser($this->user)->denies('save' , new Article())){
            abort(403);
        }
        $this->title = 'Панель администратора. Создание материала.';
        $lists = [];
        $categories =  $this->getCategories();
       // dump($categories);
        foreach($categories as $category) {
            if( !$category->parent_id) {
                $lists[$category->title] = [];
            }
            else
            {
                $lists[$categories->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        //$this->getTree($lists);
        $this->content = view(env('THEME') . '.admin.articles_create_content')->with('categories', $lists)->render();

        return $this->renderOutput();
    }


    protected function getTree(&$arrLists)
    {
        foreach($arrLists as $key=>&$arrList){
            foreach($arrList as $k=>&$value){
                if(!empty(isset($arrLists[$value]) ) && !is_array($value)){
                    $n_key = $value;
                    $value = [$value=>$arrLists[$value]];
                    unset($arrLists[$n_key]);
                }
                if(is_array($value)){
                    foreach($value as $cnt=>&$val){
                        foreach($val as $c=>&$v){
                            if(!empty(isset($arrLists[$v]) ) && !is_array($v)){
                                $n_k = $v;
                                $v = [$v=>$arrLists[$v]];
                                unset($arrLists[$n_k]);
                            }
                            if(is_array($v)){
                                foreach($v as $cnt1=>&$val1){
                                    foreach($val1 as $c1=>&$v1){
                                        if(!empty(isset($arrLists[$v1]) ) && !is_array($v1)){
                                            $n_k1 = $v1;
                                            $v1 = [$v1=>$arrLists[$v1]];
                                            unset($arrLists[$n_k1]);
                                        }
                                        if(is_array($v1)){
                                            foreach($v1 as $cnt2=>&$val2){
                                                foreach($val2 as $c2=>&$v2){
                                                    if(!empty(isset($arrLists[$v2]) ) && !is_array($v2)){
                                                        $n_k2 = $v2;
                                                        $v2 = [$v2=>$arrLists[$v2]];
                                                        unset($arrLists[$n_k2]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param   string  $alias
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $alias
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($alias)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $alias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $alias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $alias
     * @return \Illuminate\Http\Response
     */
    public function destroy($alias)
    {
        //
    }

    protected function getArticles()
    {
        return $this->a_rep->get();
    }




}

<?php


namespace App\Repositories;


use App\Models\Article;

class ArticlesRepo extends Repo
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }
    public function one($alias, $attr = []){

        $article = parent::one($alias, $attr);
        $article->load('user', 'category');
        if($article && $attr){
            $article->load('comment');
            $article->comment->load('user');
        }

        return $article;
    }
}

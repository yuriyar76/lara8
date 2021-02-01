<?php


namespace App\Repositories;


use App\Models\Article;

class ArticlesRepo extends Repo
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }
}

<?php


namespace App\Repositories;


use App\Models\Comment;
use App\Models\Portfolio;

class CommentsRepo extends Repo
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}

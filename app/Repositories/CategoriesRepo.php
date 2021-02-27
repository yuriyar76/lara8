<?php


namespace App\Repositories;

use App\Models\Category;

class CategoriesRepo extends Repo
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

}

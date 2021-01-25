<?php


namespace App\Repositories;


use App\Models\Menu;

class MenuRepo extends Repo
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}

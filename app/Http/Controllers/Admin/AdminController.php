<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoriesRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Menu;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $cat_rep;
    protected $user;
    protected $content = false;
    protected $template;
    protected $title;
    protected $vars;

    public function __construct()
    {
        $cat_rep = new CategoriesRepo(new Category());
        $this->cat_rep = $cat_rep;
    }

    public function renderOutput(){
        $this->vars = Arr::add($this->vars, 'title', $this->title );
        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.admin.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);
        if($this->content){
            $this->vars = Arr::add($this->vars, 'content', $this->content);
        }
        $footer = view(env('THEME') . '.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);

    }

    public function getMenu(){

        return \Menu::make('adminMenu', function ($menu){
            $menu->add('Статьи', ['route'=>'items.index']);
            $menu->add('Портфолио', ['route'=>'items.index']);
            $menu->add('Меню', ['route'=>'items.index']);
            $menu->add('Пользователи', ['route'=>'items.index']);
            $menu->add('Привелегии', ['route'=>'items.index']);
        });
    }

    protected function getCategories()
    {
        return $this->cat_rep->get();
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Menu;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $content = false;
    protected $template;
    protected $title;
    protected $vars;

    public function __construct()
    {
        $this->user = Auth::user();

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
            $menu->add('Статьи', ['route'=>'adminIndex']);
            $menu->add('Портфолио', ['route'=>'adminIndex']);
            $menu->add('Меню', ['route'=>'adminIndex']);
            $menu->add('Пользователи', ['route'=>'adminIndex']);
            $menu->add('Привелегии', ['route'=>'adminIndex']);
        });
    }

}

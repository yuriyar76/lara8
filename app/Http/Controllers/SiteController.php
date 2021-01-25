<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;



class SiteController extends Controller
{
    protected $p_rep; // репозиторий для хранения объекта портфолио
    protected $s_rep; // репозиторий для хранения объекта слайдер
    protected $a_rep; // репозиторий для хранения объекта статьи
    protected $m_rep; // репозиторий для хранения объекта меню
    protected $template; // шаблон
    protected $vars = [];
    protected $bar=false; // признак сайдбара на странице
    protected $contentRightBar = false; // данные правого сайдбара
    protected $contentLeftBar = false; // данные левого сайдбара

    public function __construct(MenuRepo $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars =  Arr::add( $this->vars, 'navigation', $navigation);
        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
       $menu =   $this->m_rep->get();
       $mBuild =  \Menu::make('MyNavBar', function ($m) use ($menu) {
           foreach($menu as $item){
               if($item->parent == 0){
                   $m->add($item->title, $item->path)->id($item->id);
               }else{
                   if($m->find($item->parent))
                   $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
               }
           }
        });
        return $mBuild;
    }
}

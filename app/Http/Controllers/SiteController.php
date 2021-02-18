<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\MenuRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;



class SiteController extends Controller
{
    protected $p_rep; // репозиторий для хранения объекта портфолио
    protected $s_rep; // репозиторий для хранения объекта слайдер
    protected $a_rep; // репозиторий для хранения объекта статьи
    protected $c_rep; // репозиторий комментов
    protected $cnt_rep; // репозиторий контактов
    protected $m_rep; // репозиторий для хранения объекта меню
    protected $template; // шаблон
    protected $vars = [];
    protected $bar = false; // признак сайдбара на странице
    protected $contentRightBar = false; // данные правого сайдбара
    protected $contentLeftBar = false; // данные левого сайдбара
    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $sort;
    protected $avatar;
    public $logo;
    public $slogan;
    protected $contacts_title;
    protected $portfolio_title;


    public function __construct(MenuRepo $m_rep)
    {
        $this->m_rep = $m_rep;
        $this->sort = 'desc';
        $this->avatar = ($this->settingSiteTitle())['avatar'];
        $this->logo = ($this->settingSiteTitle())['logo'];
        $this->slogan = ($this->settingSiteTitle())['slogan'];
        $this->portfolio_title = ($this->settingSiteTitle())['portfolio_title'];
        $this->contacts_title = ($this->settingSiteTitle())['contacts_title'];
     }

    protected function renderOutput()
    {
        $menu = $this->getMenu();

        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars =  Arr::add( $this->vars, 'navigation', $navigation);
        $this->vars =  Arr::add( $this->vars, 'bar', $this->bar);
        $this->vars =  Arr::add( $this->vars, 'logo', $this->logo);
        $this->vars =  Arr::add( $this->vars, 'slogan', $this->slogan);
        $this->vars =  Arr::add( $this->vars, 'portfolio_title', $this->portfolio_title);
        $this->vars =  Arr::add( $this->vars, 'contacts_title', $this->contacts_title);
        if($this->contentRightBar){
            $rightBar =  view(env('THEME') . '.rightBar')->with('content_rightbar', $this->contentRightBar)->render();
            $this->vars =  Arr::add( $this->vars, 'rightBar', $rightBar);
        }
        if($this->contentLeftBar){
            $leftBar =  view(env('THEME') . '.leftBar')->with('content_leftbar', $this->contentLeftBar)->render();
            $this->vars =  Arr::add( $this->vars, 'leftBar', $leftBar);
        }
        $copyright = view(env('THEME') . '.copyright')->render();
        $this->vars =  Arr::add( $this->vars, 'copyright', $copyright);

        $this->vars =  Arr::add( $this->vars, 'keywords', $this->keywords);
        $this->vars =  Arr::add( $this->vars, 'meta_desc', $this->meta_desc);
        $this->vars =  Arr::add( $this->vars, 'title', $this->title);
        return view($this->template)->with($this->vars);
    }


    protected function settingSiteTitle(){
        $data = new Contact();
        $Arr = $data::query()
            ->where('id', '1')
            ->get();
        $arrTitle['logo'] = $Arr[0]->logo;
        $arrTitle['avatar'] = $Arr[0]->img;
        $arrTitle['slogan'] = $Arr[0]->slogan;
        $arrTitle['portfolio_title'] = $Arr[0]->portfolio_title;
        $arrTitle['contacts_title'] = $Arr[0]->contacts_title;
        $arrTitle['keywords'] = $Arr[0]->keywords;
        $arrTitle['meta_desc'] = $Arr[0]->meta_desc;
        $arrTitle['title'] = $Arr[0]->title;
        return $arrTitle;
    }



    public function getMenu()
    {
       $menu =  $this->m_rep->get();
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

    protected function getPortfolios($take=false, $paginate=true)
    {
        $portfolios = $this->p_rep->get('*', $take, $paginate, false, $this->sort);
        if($portfolios){
            $portfolios->load('filter');
        }

        return $portfolios;
    }
}

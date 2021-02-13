<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Portfolio;
use App\Repositories\MenuRepo;
use App\Repositories\PortfolioRepo;
use Arr;
use Config;
use Illuminate\Http\Request;

class PortfoliosController extends SiteController
{

    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->p_rep = new PortfolioRepo(new Portfolio());
        $this->template = env('THEME') . '.portfolios';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->bar = 'no';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        $this->title = 'Портфолио';
        $this->sort = 'desc';
        $portfolios = $this->getPortfolios(false,true);
        $content = view(env('THEME') . '.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($alias){
        $this->bar = 'no';
        $portfolio = $this->p_rep->one($alias);
        $portfolio->load('filter');
        $this->keywords = $portfolio->keywords;
        $this->meta_desc =  $portfolio->meta_desc;
        $this->title = $portfolio->title;
        $this->sort = 'desc';
        $portfolios =  $this->getPortfolios(Config::get('settings.other_portfolios'), false);
        $content = view(env('THEME') . '.portfolio_content')->with(['portfolio'=> $portfolio, 'portfolios'=>$portfolios] )->render();
        $this->vars =  Arr::add( $this->vars, 'content', $content);
        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}

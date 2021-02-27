<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->template = env('THEME') . '.admin.index';

    }

    public function index(){
        $this->title = 'Панель администратора';
        $this->user = Auth::user();
        if(Gate::forUser($this->user)->denies('VIEW_ADMIN')){
            abort(403);
        }

        return $this->renderOutput();
    }
}

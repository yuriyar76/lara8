<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Menu;
use App\Repositories\ContactRepo;
use App\Repositories\MenuRepo;
use Arr;
use Illuminate\Http\Request;

class ContactsController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->bar = 'left';
        $epilog = view(env('THEME') . '.epilog')->render();
        $this->vars =  Arr::add( $this->vars, 'epilog', $epilog);
        $this->cnt_rep = new ContactRepo(new Contact());
        $this->template = env('THEME') . '.contacts';

    }

    public function index(Request $request)
    {
       if($request->method() === 'GET'){

           $this->keywords =  ($this->settingSiteTitle())['keywords'];
           $this->meta_desc = ($this->settingSiteTitle())['meta_desc'];
           $this->title = ($this->settingSiteTitle())['title'];
           $avatar = $this->avatar;
           $contacts = $this->getContacts();
           $content = view(env('THEME') . '.contact_content')->render();
           $this->vars =  Arr::add( $this->vars, 'content', $content);
           $this->contentLeftBar = view(env('THEME') . '.contactsBar')->with(['contacts'=> $contacts, 'avatar' => $avatar] )->render();
           return $this->renderOutput();
       }

    }

    protected function getContacts()
    {
        $contacts = $this->cnt_rep->get('*' );
        return $contacts[0];
    }


}

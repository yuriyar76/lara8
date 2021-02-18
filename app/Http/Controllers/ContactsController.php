<?php

namespace App\Http\Controllers;

use App\Mail\UserPostsend;
use App\Models\Contact;
use App\Models\Menu;
use App\Repositories\ContactRepo;
use App\Repositories\MenuRepo;
use Arr;
use Illuminate\Http\Request;
use Mail;


class ContactsController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenuRepo(new Menu()));
        $this->bar = 'left';
        $this->cnt_rep = new ContactRepo(new Contact());
        $this->template = env('THEME') . '.contacts';

    }

    public function index(Request $request)
    {
       if($request->isMethod('get')){

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
        if($request->isMethod('post')) {
           // dd($request->all());
            $messages = [

                'required' => "Поле :attribute обязательно к заполнению",
                'email' => "Поле :attribute должно соответствовать email адресу"
            ];

            $this->validate($request,[
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);
            $data = $request->all();

            $email = $data['email'];
            $userName = $data['name'];
            $mess = $data['message'];
            $message = $email .' ' . $userName . ' - ' . env('APP_NAME') . "<br/>" . $mess ;
            \Illuminate\Support\Facades\Mail::to('elsnab76.1@gmail.com')->send(new UserPostsend($message, $userName));
            //mail

        }

    }


    protected function getContacts()
    {
        $contacts = $this->cnt_rep->get('*' );
        return $contacts[0];
    }


}

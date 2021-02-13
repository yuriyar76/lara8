<?php


namespace App\Repositories;


use App\Models\Contact;

class ContactRepo extends Repo
{
    public function __construct(Contact $contacts)
    {
        $this->model = $contacts;

    }
}

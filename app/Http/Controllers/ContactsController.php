<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Repos\ContactsRepo;
use App\Http\Requests;

class ContactsController extends BaseController
{
    /**
     * @param \App\Repos\ContactsRepo $repo
     */
    public function __construct(ContactsRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = request('filters', []);

        $items = $this->repo->findAll($filters, []);

        return view('contacts.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);
        //dd($item);

        return view('contacts.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
     public function store($item_id = null)
     {
         $item = $this->bringOrNew($this->repo, $item_id);

         $data = request()->all();

         $data['contact_token'] = str_random(40);
         $item = $this->repo->update($item, $data);

         return redirect('contacts')->with('success', true);
     }
}

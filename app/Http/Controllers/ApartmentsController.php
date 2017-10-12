<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Repos\ApartmentsRepo;
use App\Http\Requests;

class ApartmentsController extends BaseController
{
    /**
     * @param \App\Repos\ApartmentsRepo $repo
     */
    public function __construct(ApartmentsRepo $repo)
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

        return view('apartments.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);
        //dd($item);

        return view('apartments.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
     public function store($item_id = null)
     {
         $item = $this->bringOrNew($this->repo, $item_id);

         $data = request()->all();

         $item = $this->repo->update($item, $data);

         return redirect('apartments')->with('success', true);
     }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repos\WikisRepo;
use Illuminate\Support\Facades\URL;

class WikisController extends BaseController
{
    /**
     * @param \App\Repos\SitesRepo $repo
     */
    public function __construct(WikisRepo $repo)
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

        $items = $this->repo->findAll($filters);

        return view('wikis.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('wikis.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();

        if (request()->file('file') && request()->file('file') != null) {
            request()->file('file')->move('uploads', $file = uniqid().'.'.request()->file('file')->getClientOriginalExtension());

            $data['file'] = URL::to('/').'/uploads/'.$file;
        }

        $item = $this->repo->update($item, $data);

        return redirect('wikis')->with('success', true);
    }
}

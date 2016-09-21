<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repos\VariationsRepo;

class VariationsController extends BaseController
{
    /**
     * @param \App\Repos\DoorsRepo $repo
     */
    public function __construct(VariationsRepo $repo)
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

        $items = $this->repo->findAll($filters, ['product']);

        return view('variations.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('variations.edit', compact('item'));
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

        return redirect('variations')->with('success', true);
    }
}

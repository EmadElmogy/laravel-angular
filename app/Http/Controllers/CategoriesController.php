<?php

namespace App\Http\Controllers;

use App\Repos\CategoriesRepo;
use App\Http\Requests;

class CategoriesController extends BaseController
{
    /**
     * @param \App\Repos\DoorsRepo $repo
     */
    public function __construct(CategoriesRepo $repo)
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

        $items = $this->repo->findAll($filters, ['parent']);

        return view('categories.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('categories.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();

        $data['parent_id'] = $data['parent_id'] && $data['parent_id'] != 'null' ? $data['parent_id'] : null;

        if (request()->file('image')) {
            request()->file('image')->move('uploads', $image = uniqid().'.'.request()->file('image')->getClientOriginalExtension());

            $data['image'] = $image;
        }

        $item = $this->repo->update($item, $data);

        return redirect('categories')->with('success', true);
    }
}

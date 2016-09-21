<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repos\ProductsRepo;

class ProductsController extends BaseController
{
    /**
     * @param \App\Repos\DoorsRepo $repo
     */
    public function __construct(ProductsRepo $repo)
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

        $items = $this->repo->findAll($filters, ['category.parent']);

        return view('products.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('products.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();

        if (request()->file('image')) {
            request()->file('image')->move('uploads', $image = uniqid().'.'.request()->file('image')->getClientOriginalExtension());

            $data['image'] = $image;
        }

        $item = $this->repo->update($item, $data);

        return redirect('products')->with('success', true);
    }
}

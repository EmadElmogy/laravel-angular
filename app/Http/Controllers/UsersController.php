<?php

namespace App\Http\Controllers;

use App\Repos\SitesRepo;

use App\Http\Requests;
use App\Repos\UsersRepo;

class UsersController extends BaseController
{
    /**
     * @param \App\Repos\SitesRepo $repo
     */
    public function __construct(UsersRepo $repo)
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

        return view('users.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('users.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();

        if ($item && ! @$data['password']) {
            unset($data['password']);
        }

        $item = $this->repo->update($item, $data);

        return redirect('admins')->with('success', true);
    }
}

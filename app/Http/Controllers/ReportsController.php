<?php

namespace App\Http\Controllers;

use App\Repos\ReportsRepo;

use App\Http\Requests;

class ReportsController extends BaseController
{
    /**
     * @param \App\Repos\SitesRepo $repo
     */
    public function __construct(ReportsRepo $repo)
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

        $items = $this->repo->findAll($filters, ['door.site', 'advisor'], false)->paginate(40);

        return view('reports.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('reports.show', compact('item'));
    }
}

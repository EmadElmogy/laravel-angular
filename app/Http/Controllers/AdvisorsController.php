<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Repos\AdvisorsRepo;
use App\Http\Requests;

class AdvisorsController extends BaseController
{
    /**
     * @param \App\Repos\DoorsRepo $repo
     */
    public function __construct(AdvisorsRepo $repo)
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

        $items = $this->repo->findAll($filters, ['door.site']);

        return view('advisors.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('advisors.edit', compact('item'));
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

        return redirect('advisors')->with('success', true);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function attendance()
    {
        $items = Attendance::select('*')
            ->when(request('door_id'), function ($q) {
                return $q->where('attendance.door_id', request('door_id'));
            })
            ->when(request('advisor_id'), function ($q) {
                return $q->where('attendance.advisor_id', request('advisor_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('attendance.login_time', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('attendance.login_time', [request('from_date'), request('to_date')]);
            })->orderBy('attendance.login_time','desc')->paginate(20);

           // dd($items);
        return view('advisors.attendance', compact('items'));
    }
}

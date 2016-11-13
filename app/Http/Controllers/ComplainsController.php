<?php

namespace App\Http\Controllers;

use App\Repos\CategoriesRepo;
use App\Http\Requests;
use App\Repos\ComplainsRepo;

class ComplainsController extends BaseController
{
    /**
     * @param \App\Repos\DoorsRepo $repo
     */
    public function __construct(ComplainsRepo $repo)
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

        $items = $this->repo->findAll($filters, ['advisor', 'door']);
        //dd($items);
        return view('complains.index', compact('items'));
    }

    public function show_image($item_id=null){
      $item = $this->bringOrNew($this->repo, $item_id);
      //dd($item->image);
        $image = base64_decode(request('image'));
        $imagePath = 'uploads/' . md5(time()) . '.jpg';
        file_put_contents(public_path() . '/' . $imagePath, $image);
        \DB::table('complains')->where('id','=',$item_id)->update(['image'=>$imagePath]);
        return "updated";
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('complains.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();

        $data['parent_id'] = $data['parent_id'] ?: null;

        $item = $this->repo->update($item, $data);

        return redirect('complains')->with('success', true);
    }
}

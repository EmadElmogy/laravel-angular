<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repos\CustomerRepo;
use Excel;


class customersController extends BaseController
{
    /**
     * @param \App\Repos\SitesRepo $repo
     */
    public function __construct(CustomerRepo $repo)
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

        $items = $this->repo->findAll($filters)->paginate(40);

        return view('customers.index', compact('items'));
    }

    public function customer_excel(){
        $filters = request('filters', []);

        $results = $this->repo->findAll($filters);

        Excel::create('customers', function($excel) use($results) {
            $excel->sheet('Sheet 1', function($sheet) use($results) {
                foreach ($results as &$result) {
                    $result = (array)$result;
                }
                $sheet->fromArray($results);
            });
        })->export('xls');
    }

   public function show_orders($item_id = null){
      $item1 = $this->bringOrNew($this->repo, $item_id);
      $items=\DB::table('reports')->where('customer_id','=',$item_id)
                  ->join('doors','reports.door_id','=','doors.id')
                  ->join('advisors','reports.advisor_id','=','advisors.id')
                  ->select('*','advisors.name as advisor_name','doors.name as door_name')
                  ->paginate(50);
      //dd($reports);
      return view('customers.show_orders', compact('items','item1'));

    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);
        $report=\DB::table('reports')->where('customer_id','=',$item_id)->first();
        $orders=\DB::table('report_products')
                    ->where('report_id','=',$report->id)
                    ->join('variations','report_products.variation_id','=','variations.id')
                    ->join('products','variations.product_id','=','products.id')
                    ->select('*','products.name as product_name','variations.name as variation_name')
                    ->get();
//       dd($report);
        $advisor_name=\DB::table('advisors')->where('id','=',$report->advisor_id)->first();
        $door=\DB::table('doors')->where('id','=',$report->door_id)->first();
        return view('customers.show', compact('orders','report','item','advisor_name','door'));
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

        return redirect('wikis')->with('success', true);
    }

}

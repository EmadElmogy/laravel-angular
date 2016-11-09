<?php

namespace App\Http\Controllers;

use App\Category;
use App\Door;
use App\Http\Requests;
use App\Product;
use App\Variation;
use Illuminate\Support\Facades\DB;
use App\Repos\DoorsRepo;
use Excel;

class StockController extends BaseController
{

  public function __construct(DoorsRepo $repo)
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
//dd($filters);
      $doors = $this->repo->findAll($filters, []);

      //  $doors = Door::all();

        return view('stock.index', compact('doors'));
    }


    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
        $filters = request('filters', []);
//        dd($filters);
        $door = Door::find($item_id);

        $items = Variation::with('product.category')
            ->when(@$filters['barcode'], function ($q) {
             return $q->where('variations.id', request('filters.barcode'));
            })->when(@$filters['product_id'], function ($q) {
                return $q->where('variations.product_id', request('filters.product_id'));
            })
            ->join('variations_stock','variations.id','=','variations_stock.variation_id')
            //->where('variations_stock.door_id','=',$item_id)
            ->get();

        $stock = collect(DB::table('variations_stock')->get());

        return view('stock.edit', compact('door', 'items', 'stock'));
    }

    public function excel_stock($item_id = null){
      $filters = request('filters', []);
//        dd($filters);
      $door = Door::find($item_id);

      $items = Variation::with('product.category')
          ->when(@$filters['barcode'], function ($q) {
           return $q->where('variations.id', request('filters.barcode'));
          })->when(@$filters['product_id'], function ($q) {
              return $q->where('variations.product_id', request('filters.product_id'));
          })
          ->join('variations_stock','variations.id','=','variations_stock.variation_id')
          ->where('variations_stock.door_id','=',$item_id)
          ->select('product_id','variations.name','barcode','stock')->get();

      $stock = collect(DB::table('variations_stock')->get());
      Excel::create('Stock', function($excel) use($items,$stock) {
          $excel->sheet('Sheet 1', function($sheet) use($items) {
              foreach ($items as &$item) {
                  $item = (array)$item;
              }
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function store($item_id = null)
    {
        $door = Door::find($item_id);

        $data = request('variation');

        foreach ($data as $variationId => $value) {
            $record = DB::table('variations_stock')->where([
                'variation_id' => $variationId,
                'door_id' => $door->id,
            ]);

            if ($current = $record->first()) {
                $record->update([
                    'stock' => $value
                ]);
            } else {
                DB::table('variations_stock')->insert([
                    'variation_id' => $variationId,
                    'door_id' => $door->id,
                    'stock' => $value,
                ]);
            }
        }

        return redirect('stock')->with('success', true);
    }

    public function reset_all(){
      DB::table('variations_stock')->truncate();
    //  return "success";
      return redirect()->back()->with('success', true);
    }

}

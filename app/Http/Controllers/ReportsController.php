<?php

namespace App\Http\Controllers;

use App\Report;
use App\Repos\ReportsRepo;
use Carbon\Carbon;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Excel;


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
      //  var_dump(date('m-d-Y',strtotime(Carbon::now()->toDateTimeString()))); die;

        $items = $this->repo->findAll($filters, ['door.site', 'advisor'], false)->paginate(40);



        return view('reports.index', compact('items'));
    }

    public function excelindex(){
        //$filters = request('filters', []);

       // $results = $this->repo->findAll($filters=[], ['door.site', 'advisor'], false)->paginate(40);
       // $results = Report::all();
        $items = DB::table('reports')
            ->join('advisors', 'advisors.id', '=', 'reports.advisor_id')
            ->join('doors', 'doors.id', '=', 'reports.door_id')
           ->join('customers', 'customers.id', '=', 'reports.customer_id')
            ->select('advisors.name as advisor_name', 'doors.name as door_name', 'customers.name as customer_name','reports.basket_size','reports.basket_value',DB::raw('DATE_FORMAT(reports.date,\'%Y-%m-%d\') as Date'))
            ->orderBy('reports.id', 'DESC')
            ->when(request('door_id'), function ($q) {
                return $q->where('reports.door_id', request('door_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
        Excel::create('orders', function($excel) use($items) {
            $excel->sheet('Sheet 1', function($sheet) use($items) {
                foreach ($items as &$item) {
                    $item = (array)$item;
                }
                $sheet->fromArray($items);
                //$sheet->loadView('reports.index')->with('items',$items);

            });
        })->export('xls');

    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function show_item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('reports.show', compact('item','item_id'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function byProducts()
    {
        $results = DB::table('report_products')
            ->join('variations', 'variations.id', '=', 'report_products.variation_id')
            ->join('products', 'products.id', '=', 'variations.product_id')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->groupBy('variation_id')
            ->select('products.name as product_name', 'variations.name as variation_name', 'variations.barcode as barcode')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('barcode'), function ($q) {
                return $q->where('variations.barcode', request('barcode'));
            })
            ->when(request('door_id'), function ($q) {
                return $q->where('reports.door_id', request('door_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
//        Excel::create('reports', function($excel) use($results) {
//            $excel->sheet('Sheet 1', function($sheet) use($results) {
//                foreach ($results as &$result) {
//                    $result = (array)$result;
//                }
//                $sheet->fromArray($results);
//            });
//        })->export('xls');



        return view('reports.by-products', compact('results'));
    }

      public function excelbyProduct(){
          $results = DB::table('report_products')
              ->join('variations', 'variations.id', '=', 'report_products.variation_id')
              ->join('products', 'products.id', '=', 'variations.product_id')
              ->join('reports', 'reports.id', '=', 'report_products.report_id')
              ->groupBy('variation_id')
              ->select('products.name as product_name', 'variations.name as variation_name', 'variations.barcode as barcode')
              ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
              ->orderBy('sales', 'DESC')
              ->when(request('barcode'), function ($q) {
                  return $q->where('variations.barcode', request('barcode'));
              })
              ->when(request('door_id'), function ($q) {
                  return $q->where('reports.door_id', request('door_id'));
              })
              ->when(request('from_date') && ! request('to_date'), function ($q) {
                  return $q->whereDate('reports.date', '=', request('from_date'));
              })
              ->when(request('from_date') && request('to_date'), function ($q) {
                  return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
              })
              ->get();
          Excel::create('Product_reports', function($excel) use($results) {
              $excel->sheet('Sheet 1', function($sheet) use($results) {
                  foreach ($results as &$result) {
                      $result = (array)$result;
                  }
                  $sheet->fromArray($results);
              });
          })->export('xls');
      }

    public function excelbyCategory(){
        $results = DB::table('report_products')
            ->join('variations', 'variations.id', '=', 'report_products.variation_id')
            ->join('products', 'products.id', '=', 'variations.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->groupBy('categories.id')
            ->select('categories.name as category_name')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('door_id'), function ($q) {
                return $q->where('reports.door_id', request('door_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
        Excel::create('Category_reports', function($excel) use($results) {
            $excel->sheet('Sheet 1', function($sheet) use($results) {
                foreach ($results as &$result) {
                    $result = (array)$result;
                }
                $sheet->fromArray($results);
            });
        })->export('xls');
    }
    public function excelbyDoor(){
        $results = DB::table('report_products')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->join('doors', 'doors.id', '=', 'reports.door_id')
            ->groupBy('reports.door_id')
            ->select('doors.name as door_name')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
        Excel::create('Door_reports', function($excel) use($results) {
            $excel->sheet('Sheet 1', function($sheet) use($results) {
                foreach ($results as &$result) {
                    $result = (array)$result;
                }
                $sheet->fromArray($results);
            });
        })->export('xls');
    }
    public function excelbyAdvisor(){
        $results = DB::table('report_products')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->join('advisors', 'advisors.id', '=', 'reports.advisor_id')
            ->groupBy('reports.advisor_id')
            ->select('advisors.name as advisor_name','advisors.target')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
        Excel::create('Advisor_reports', function($excel) use($results) {
            $excel->sheet('Sheet 1', function($sheet) use($results) {
                foreach ($results as &$result) {
                    $result = (array)$result;
                }
                $sheet->fromArray($results);
            });
        })->export('xls');
    }



    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function byCategories()
    {
        $results = DB::table('report_products')
            ->join('variations', 'variations.id', '=', 'report_products.variation_id')
            ->join('products', 'products.id', '=', 'variations.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->groupBy('categories.id')
            ->select('categories.name as category_name')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('door_id'), function ($q) {
                return $q->where('reports.door_id', request('door_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();

        return view('reports.by-categories', compact('results'));
    }

    public function byBrand(){
      $Brands=\App\Category::$BRANDS;
      $results = DB::table('report_products')
          ->join('variations', 'variations.id', '=', 'report_products.variation_id')
          ->join('products', 'products.id', '=', 'variations.product_id')
          ->join('categories', 'categories.id', '=', 'products.category_id')
          ->join('reports', 'reports.id', '=', 'report_products.report_id')
          ->groupBy('categories.id')
          ->select('categories.name as category_name','categories.brand')
          ->selectRaw('SUM(sales) as sales ,SUM(basket_value) as sell_out')
          ->orderBy('sales', 'DESC')
          ->when(request('door_id'), function ($q) {
              return $q->where('reports.door_id', request('door_id'));
          })
          ->when(request('from_date') && ! request('to_date'), function ($q) {
              return $q->whereDate('reports.date', '=', request('from_date'));
          })
          ->when(request('from_date') && request('to_date'), function ($q) {
              return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
          })
          ->first();
        //dd($Brands);
      return view('reports.bybrand', compact('results','Brands'));
    }

    public function brands_excel(){
      $sheet_array=array();
      $Brands=\App\Category::$BRANDS;
      $sheet_array[]=$Brands;
      foreach ($Brands as $key => $value) {
        @$brand_items = DB::table('report_products')
            ->join('variations', 'variations.id', '=', 'report_products.variation_id')
            ->join('products', 'products.id', '=', 'variations.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
          //  ->where('categories.brand','=',$key)
            ->groupBy('categories.id')
            ->select('brand')
            ->selectRaw('SUM(sales) as sales ,SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('door_id'), function ($q) {
                return $q->where('reports.door_id', request('door_id'));
            })
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();
            //dd($key);
            array_push($sheet_array,$brand_items);
          //  $sheet_array[]=@$brand_items;
        //  dd($sheet_array);
      }
      Excel::create('Brands_report', function($excel) use($brand_items) {
          $excel->sheet('Sheet 1', function($sheet) use($brand_items) {
              foreach ($brand_items as &$brand_item) {
                  $brand_item = (array)$brand_item;
              }
              $sheet->fromArray($brand_items);
          });
      })->export('xls');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function byDoors()
    {
        $results = DB::table('report_products')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->join('doors', 'doors.id', '=', 'reports.door_id')
            ->groupBy('reports.door_id')
            ->select('doors.name as door_name')
            ->selectRaw('SUM(sales) as sales, SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();

        return view('reports.by-doors', compact('results'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function byAdvisors()
    {
        $results = DB::table('report_products')
            ->join('reports', 'reports.id', '=', 'report_products.report_id')
            ->join('advisors', 'advisors.id', '=', 'reports.advisor_id')
            ->groupBy('reports.advisor_id')
            ->select('advisors.name as advisor_name','advisors.target')
            ->selectRaw('SUM(sales) as sales , SUM(basket_value) as sell_out')
            ->orderBy('sales', 'DESC')
            ->when(request('from_date') && ! request('to_date'), function ($q) {
                return $q->whereDate('reports.date', '=', request('from_date'));
            })
            ->when(request('from_date') && request('to_date'), function ($q) {
                return $q->whereBetween('reports.date', [request('from_date'), request('to_date')]);
            })
            ->get();

        return view('reports.by-advisors', compact('results'));
    }

    public function item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('reports.edit', compact('item'));
    }


    public function store(\Request $request ,$item_id = null)
    {
//        $report_id=\DB::table('report_products')
           // ->where('variation_id', $item_id)->first();
//        dd(request()->report_id);
//
//        $item = $this->bringOrNew($this->repo, $item_id);
        \DB::table('report_products')
            ->where('variation_id', $item_id)
            ->where('report_id', request()->report_id)
            ->update(['sales' => request()->sales]);


        return redirect()->back()->with('success', true);
    }


}

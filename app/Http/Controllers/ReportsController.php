<?php

namespace App\Http\Controllers;

use App\Report;
use App\Repos\ReportsRepo;

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

        $items = $this->repo->findAll($filters, ['door.site', 'advisor'], false)->paginate(40);



        return view('reports.index', compact('items'));
    }

    public function excelindex(){
        //$filters = request('filters', []);

       // $results = $this->repo->findAll($filters=[], ['door.site', 'advisor'], false)->paginate(40);
       // $results = Report::all();
        $results = DB::table('reports')
            ->join('advisors', 'advisors.id', '=', 'reports.advisor_id')
            ->join('doors', 'doors.id', '=', 'reports.door_id')
           ->join('customers', 'customers.id', '=', 'reports.customer_id')
            //->groupBy('variation_id')
            ->select('advisors.name as advisor_name', 'doors.name as door_name', 'customers.name as customer_name')
           // ->selectRaw('SUM(sales) as sales')
            ->orderBy('reports.id', 'DESC')
           /* ->when(request('barcode'), function ($q) {
                return $q->where('variations.barcode', request('barcode'));
            })*/
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

        Excel::create('orders', function($excel) use($results) {
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
    public function show_item($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        return view('reports.show', compact('item'));
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
            ->selectRaw('SUM(sales) as sales')
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
              ->selectRaw('SUM(sales) as sales')
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
            ->selectRaw('SUM(sales) as sales')
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
            ->selectRaw('SUM(sales) as sales')
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
            ->select('advisors.name as advisor_name')
            ->selectRaw('SUM(sales) as sales')
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
            ->selectRaw('SUM(sales) as sales')
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
            ->selectRaw('SUM(sales) as sales')
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
            ->select('advisors.name as advisor_name')
            ->selectRaw('SUM(sales) as sales')
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


    public function store($item_id = null)
    {
        $item = $this->bringOrNew($this->repo, $item_id);

        $data = request()->all();
//dd($data);
        $item = $this->repo->update($item, $data);

        return redirect('reports')->with('success', true);
    }


}

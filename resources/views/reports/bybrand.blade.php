@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Sales by Brand</h4></div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-3">
                            <label>Door</label>
                            <select name="door_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'All Doors']+\App\Door::pluck('name','id')->toArray(), request('door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>From Date:</label>
                            <input type="date" class="form-control" name="from_date" placeholder="Date" value="{{request('from_date')}}">
                        </div>
                        <div class="col-md-3">
                            <label>To Date:</label>
                            <input type="date" class="form-control" name="to_date" placeholder="Date" value="{{request('to_date')}}">
                        </div>
                        <div class="col-md-2">
                            <label>Filter</label>
                            <button class="btn btn-info btn-sm" style="display:block;">
                                <i class="icon-filter3 position-left"></i> Filter
                            </button>
                        </div>
                        <div style="line-height: 6em;">
                            <a href="{{URL('reports/sales/brands_excel?from_date='.request('from_date').'&to_date='.request('to_date').'&door='.request('door_id'))}}" class="btn btn-success">Export to csv</a>
                        </div>
                    </form>

                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Brand</th>
                                <!-- <th>Category</th> -->
                                <th>Sales By Unit</th>
                                <th>Sales By Value</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php  $total_value=0; $total_unit=0; ?>

                              @foreach($Brands as $key=>$brand)
                              <?php
                              @$brand_items = DB::table('report_products')
                                  ->join('variations', 'variations.id', '=', 'report_products.variation_id')
                                  ->join('products', 'products.id', '=', 'variations.product_id')
                                  ->join('categories', 'categories.id', '=', 'products.category_id')
                                  ->join('reports', 'reports.id', '=', 'report_products.report_id')
                                  ->join('advisors', 'advisors.id', '=', 'reports.advisor_id')
                                  ->join('customers', 'customers.id', '=', 'reports.customer_id')
                                  ->where('categories.brand','=',$key)
                                  ->groupBy('categories.brand')
                                  ->select('categories.name as category_name','brand')
                                  ->selectRaw('SUM(sales) as sales ,SUM(report_products.sales*products.price) as sell_out')
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

                               ?>
                               @foreach($brand_items as $brand_item)

                               <?php $total_unit += @$brand_item->sales; $total_value += @$brand_item->sell_out;?>
                               @endforeach

                                <tr>
                                   <td>
                                     {{$brand}}
                                   </td>

                                   <td>
                                     {{$total_unit}}
                                   </td>
                                   <td>
                                     {{$total_value}}
                                   </td>
                                </tr>
                                <?php $total_unit=0; $total_value=0; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop

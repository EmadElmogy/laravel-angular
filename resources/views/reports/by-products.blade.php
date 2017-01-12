@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Sales by products</h4></div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-2">
                            <label>Barcode</label>
                            <input type="text" class="form-control" name="barcode" value="{{request('barcode')}}">
                        </div>
                        <div class="col-md-2">
                            <label>Door</label>
                            <select name="door_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'All Doors']+\App\Door::pluck('name','id')->toArray(), request('door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>Brand</label>
                            <select name="brand" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'All Brands']+\App\Category::$BRANDS, request('brand')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>From Date:</label>
                            <input type="date" class="form-control" name="from_date" placeholder="Date" value="{{request('from_date')}}">
                        </div>
                        <div class="col-md-2">
                            <label>To Date:</label>
                            <input type="date" class="form-control" name="to_date" placeholder="Date" value="{{request('to_date')}}">
                        </div>
                        <div class="col-md-2">
                            <label>Filter</label>
                            <button class="btn btn-info btn-sm" style="display:block;">
                                <i class="icon-filter3 position-left"></i> Filter
                            </button>
                        </div>

                    </form>
                    <div style="line-height: 6em;">
                    <a href="{{URL('reports/sales/product_excel?from_date='.request('from_date').'&to_date='.request('to_date').'&door_id='.request('door_id').'&brand='.request('brand').'&barcode='.request('barcode'))}}" class="btn btn-success">Export to csv</a>
                    </div>
                </div>


                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Barcode</th>
                                <th>Sales By Unit</th>
                                <th>Sales By Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $item)
                                <tr>
                                    <td>{{$item->variation_name}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->barcode}}</td>
                                    <td>{{$item->sales}}</td>
                                    <td>{{$item->sell_out}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!!$results->render()!!}

            </div>
        </div>

    </div>

@stop

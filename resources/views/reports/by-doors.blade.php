@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Sales by doors</h4></div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="row mb-20">
                    <form action="">
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
                            <a href="{{URL('reports/sales/excelbyDoor?from_date='.request('from_date').'&to_date='.request('to_date'))}}" class="btn btn-success">Export to csv</a>
                        </div>
                    </form>

                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Door</th>
                                <th>Sales By Unit</th>
                                <th>
                                  Sales By Value
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $item)
                            <?php $basket_value_x=\DB::table('reports')->where('door_id','=',$item->door_id)->selectRaw('SUM(basket_value) as total_basket,SUM(basket_size) as total_size')->first(); ?>
                                <tr>
                                    <td>{{$item->door_name}}</td>
                                    <td> {{$basket_value_x->total_size}}</td>
                                    <td>
                                      {{$basket_value_x->total_basket}}
                                    </td>
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

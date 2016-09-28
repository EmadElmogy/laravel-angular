@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Sales by advisors</h4></div>
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
                    </form>
                    <div style="line-height: 6em;">
                        <a href="{{route('excelbyAdvisor')}}" class="btn btn-success">Export to csv</a>
                    </div>
                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Advisor</th>
                                <th>Sales</th>
                                <th>Target</th>
                                <th>Sell Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $item)
                                <tr>
                                    <td>{{$item->advisor_name}}</td>
                                    @if($item->target <= $item->sell_out)
                                    <td><span style="color:green">{{$item->sales}}</span></td>
                                    @elseif($item->target >= $item->sell_out)
                                    <td><span style="color:red">{{$item->sales}}</span></td>
                                    @endif
                                    <td>{{$item->target}}</td>
                                    <td>{{$item->sell_out}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop

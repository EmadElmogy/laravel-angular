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
                    </form>
                    <div style="line-height: 6em;">
                        <a href="{{route('excelbyCategory')}}" class="btn btn-success">Export to csv</a>
                    </div>
                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Brand</th>
                                <!-- <th>Category</th> -->
                                <!-- <th>Sales By Unit</th> -->
                                <!-- <th>Sales By Value</th> -->
                            </tr>
                            </thead>
                            <tbody>
                              <?php $total_value=0; $total_unit=0; ?>
                                <tr>
                                  @if($results->brand == "2")
                                    <td>Maybelline</td>
                                  @elseif($results->brand == "1")
                                  <td>L\'Oreal Paris</td>
                                   @elseif($results->brand == "3")
                                   <td>HairCare</td>

                                  @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

@stop

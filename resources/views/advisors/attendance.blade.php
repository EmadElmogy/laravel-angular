@extends('common.base')

@section('browser_subtitle', 'Advisors')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Advisors Attendance</h4></div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif

                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-2">
                            <label>Door:</label>
                            <select name="door_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'All doors']+\App\Door::pluck('name','id')->toArray(), request('door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Advisor:</label>
                            <select name="advisor_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'All advisors']+\App\Advisor::pluck('name','id')->toArray(), request('advisor_id')) !!}
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
                        <div style="line-height: 6em;">
                            <a href="{{URL('advisors/attendance_sheet?from_date='.request('from_date').'&to_date='.request('to_date').'&door_id='.request('door_id').'&advisor_id='.request('advisor_id'))}}" class="btn btn-success">Export to csv</a>
                        </div>
                    </form>
                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Advisor</th>
                                <th>Door</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Sign In Range</th>
                                <th>Sign Out Range</th>
                            </tr>
                            </thead>
                            <tbody>


                            @forelse($items as $item)

                                <tr>
                                    <td class="v-align-middle semi-bold">{{@$item->advisor->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->door->site->name}}: {{$item->door->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->login_time}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->logout_time}}</td>
                                    @if($item->sign_in_range =='1')
                                    <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-check" style="font-size:30px;color:green;"></i></td>
                                        @elseif($item->sign_in_range =='0')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-remove-sign" style="font-size:30px;color:red;"></i></td>
                                        @elseif($item->sign_in_range =='2')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-globe" style="font-size:30px;color:grey;"></i></td>
                                        @elseif($item->sign_in_range =='-1')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-question-sign" style="font-size:30px;color:black;"></i></td>

                                    @endif
                                    @if($item->sign_out_range =='1')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-check" style="font-size:30px;color:green;"></i></td>
                                    @elseif($item->sign_out_range =='0')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-remove-sign" style="font-size:30px;color:red;"></i></td>
                                    @elseif($item->sign_out_range =='2')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-globe" style="font-size:30px;color:grey;"></i></td>
                                    @elseif($item->sign_out_range =='-1')
                                        <td class="v-align-middle semi-bold"><i class="glyphicon glyphicon-question-sign" style="font-size:30px;color:black;"></i></td>

                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="41" class="text-center">No records were found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {!!$items->render()!!}
            </div>
        </div>

    </div>

@stop

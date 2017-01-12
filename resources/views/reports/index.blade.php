@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Daily Reports</h4></div>
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
                            <select name="door_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Door']+\App\Door::pluck('name','id')->toArray(), request('filters.door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="advisor_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Advisor']+\App\Advisor::pluck('name','id')->toArray(), request('filters.advisor_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="customer_id" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Customer']+\App\Customer::pluck('name','id')->toArray(), request('filters.customer_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date" placeholder="Date" value="{{request('filters.date')}}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info btn-sm">
                                <i class="icon-filter3 position-left"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-1" style="padding-left: 4px;">
                            <a href="{{route('excelindex')}}" class="btn btn-success">Export to csv</a>
                        </div>
                    </form>


                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Door</th>
                                <th>Advisor</th>
                                <th>Customer</th>
                                <th>Basket Size</th>
                                <th>Basket Value</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)

                                <tr>
                                    <td class="v-align-middle semi-bold">
                                        {{$item->Date}}
                                    </td>
                                    <td class="v-align-middle semi-bold">{{@$item->door_name}}</td>
                                    <td class="v-align-middle semi-bold">{{@$item->advisor_name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->customer_name ? "{$item->customer_name} ({$item->customer_mobile})" : ''}}</td>
                                    <td class="v-align-middle semi-bold">{{@$item->basket_size}}</td>
                                    <td class="v-align-middle semi-bold">{{@$item->basket_value}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('reports/show_item/'.$item->report_id)}}" class="btn btn-primary btn-xs"><i class="icon-file-eye"></i></a>
                                        {{--<a href="{{url('reports/item/'.$item->report_id)}}" class="btn btn-success btn-xs"><i class="icon-pencil5"></i></a>--}}
                                        <a href="{{url('reports/item/'.$item->report_id)}}" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>

                                    </td>
                                </tr>
                                <?php
                                       // dd($basket_value);
                                // \DB::table('reports')
                                //         ->where('id', $item->id)
                                //         ->update(['basket_size' =>$basket_size->sum,'basket_value'=> $basket_value]);
                                ?>
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

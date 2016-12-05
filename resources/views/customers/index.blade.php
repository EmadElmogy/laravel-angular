@extends('common.base')

@section('browser_subtitle', 'Customers')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Customers Management</h4></div>

            <div class="heading-elements">
                {{--<div class="heading-btn-group">
                    <a href="{{url('customers/item')}}" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>Add New</span></a>
                </div>--}}
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row mb-20">
            <form action="">
                {{--<div class="col-md-2">
                    <select name="filters[door_id]" class="form-control select2">
                        {!! selectBoxOptionsBuilder([''=>'Name']+\App\Customer::pluck('name','id')->toArray(), request('filters.customer_id')) !!}
                    </select>
                </div>--}}
                <div class="col-md-2">
                    <input type="text" class="form-control" name="filters[name]" placeholder="Name" value="{{request('filters.name')}}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="filters[mobile]" placeholder="Mobile" value="{{request('filters.mobile')}}">
                </div>
                <div class="col-md-2">
                    <select name="filters[area]" class="form-control select2">
                        {!! selectBoxOptionsBuilder([''=>'Area']+\App\Customer::pluck('area','area')->toArray(), request('filters.area')) !!}
                    </select>
                </div>
                {{--<div class="col-md-2">--}}
                    {{--<input type="text" class="form-control" name="filters[area]" placeholder="Area" value="{{request('filters.area')}}">--}}
                {{--</div>--}}
                <div class="col-md-2">
                    <input type="text" class="form-control" name="filters[email]" placeholder="Email" value="{{request('filters.email')}}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-info btn-sm">
                        <i class="icon-filter3 position-left"></i> Filter
                    </button>
                </div>
            </form>
            <div class="col-md-1" style="padding-left: 4em;">
                <a href="{{route('customerExcel')}}" class="btn btn-success">Export to csv</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif


                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Area</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="v-align-middle semi-bold">{{$item->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->mobile}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->area}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->email}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('customers/show_orders/'.$item->id)}}" class="btn btn-primary btn-xs"><i class="icon-file-eye"></i></a>
                                        <a href="{{url('customers/item/'.$item->id)}}" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
                                    </td>
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

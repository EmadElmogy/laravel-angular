@extends('common.base')

@section('browser_subtitle', 'Advisors')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Advisors Management</h4></div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="{{url('advisors/item')}}" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>Add New</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif


                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="filters[name]" placeholder="Name" value="{{request('filters.name')}}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="filters[phone]" placeholder="Phone" value="{{request('filters.phone')}}">
                        </div>
                        <div class="col-md-2">
                            <select name="filters[day]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Day Off']+\App\Advisor::$DAYS, request('filters.day')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="filters[door_id]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Door']+\App\Door::pluck('name','id')->toArray(), request('filters.door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info btn-sm">
                                <i class="icon-filter3 position-left"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th style="width:20%">Name</th>
                                <th style="width:20%">Door</th>
                                <th style="width:20%">Phone</th>
                                <th style="width:20%">Username</th>
                                <th style="width:20%">Day Off</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="v-align-middle semi-bold">{{$item->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->door->site->name}}: {{$item->door->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->phone}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->username}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->dayName}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('advisors/item/'.$item->id)}}" class="btn btn-primary btn-xs"><i class="icon-pencil5"></i></a>
                                        <a href="{{url('advisors/item/'.$item->id)}}" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
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

            </div>
        </div>

    </div>

@stop
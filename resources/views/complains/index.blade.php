@extends('common.base')

@section('browser_subtitle', 'Complains')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Complains</h4></div>
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
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="filters[date]" placeholder="Date" value="{{request('filters.date')}}">
                        </div>
                        <div class="col-md-2">
                            <select name="filters[advisor_id]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Advisor']+\App\Advisor::pluck('name','id')->toArray(), request('filters.advisor_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="filters[door_id]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Door']+\App\Advisor::pluck('name','id')->toArray(), request('filters.door_id')) !!}
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
                                <th style="width:15%">Advisor</th>
                                <th style="width:15%">Door</th>
                                <th style="width:15%">Date</th>
                                <th>Type</th>
                                <th>Comment</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td class="v-align-middle semi-bold">{{$item->advisor->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->door->name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->date}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->typeName}}</td>
                                    <td class="v-align-middle semi-bold">{{$item->comment}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('categories/item/'.$item->id)}}" class="btn btn-primary btn-xs"><i class="icon-pencil5"></i></a>
                                        <a href="{{url('categories/item/'.$item->id)}}" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
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
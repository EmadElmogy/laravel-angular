@extends('common.base')

@section('browser_subtitle', 'stock')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Stock</h4></div>
        </div>
    </div>

    <div class="content">
        {{--<div class="row mb-20">--}}
            {{--<form action="">--}}
                {{--<div class="col-md-2">--}}
                    {{--<input type="text" class="form-control" name="filters[name]" placeholder="Name" value="{{request('filters.name')}}">--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                    {{--<select name="filters[parent_id]" class="form-control select2">--}}
                        {{--{!! selectBoxOptionsBuilder([''=>'Parent']+\App\Category::whereNull('parent_id')->pluck('name','id')->toArray(), request('filters.parent_id')) !!}--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                    {{--<button class="btn btn-info btn-sm">--}}
                        {{--<i class="icon-filter3 position-left"></i> Filter--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

        <div class="row">
          <div class="col-md-12" style="float:right;margin-top:3px;">
            <a href="{{route('reset')}}" class="btn btn-danger"><i class="icon-pencil icon-large"> Reset</i></a>
          </div>

            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif


                <h4>Please select a door to view stock</h4>

                <div class="panel panel-flat">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            @forelse($doors as $door)
                                <tr>
                                    <td class="v-align-middle semi-bold">
                                        <a href="{{url('stock/'.$door->id)}}">{{$door->name}}</a>
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

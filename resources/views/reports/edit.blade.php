@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Reports Management: {{$item->id ? $item->title : 'Add New'}}</h4></div>
        </div>
    </div>

    <div class="content">

        @if(session('validationErrors'))
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"></button>
                {{session('validationErrors')}}
            </div>
        @endif

        <div class="panel panel-flat">
            <div class="panel-body">
                <form role="form" method="post" autocomplete="off" class="form-horizontal form-validate-jquery" enctype="multipart/form-data">
                    {{csrf_field()}}



                    {{--<div class="form-group">
                        <label class="control-label col-lg-2">Door<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="door_id" class="form-control select2" required="required">
                                {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Door::pluck('name','id')->toArray(), old('door_id', $item->door_id)) !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Door<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="advisor_id" class="form-control select2" required="required">
                                {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Advisor::pluck('name','id')->toArray(), old('advisor_id', $item->advisor_id)) !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Customer <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="customer_id" class="form-control select2" required="required">
                                {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Customer::pluck('name','id')->toArray(), old('customer_id', $item->customer_id)) !!}
                            </select>
                        </div>
                    </div>--}}

                     {{dd($item->variations)}}

                    <div class="form-group">
                        <label class="control-label col-lg-2">Link</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"   name="link" value="{{$item->link ?: old('link')}}">
                        </div>
                    </div>



                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </form>
            </div>
        </div>


    </div>

@stop
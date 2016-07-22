@extends('common.base')

@section('browser_subtitle', 'Advisors')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Advisors Management: {{$item->id ? $item->name : 'Add New'}}</h4></div>
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
                <form role="form" method="post" autocomplete="off" class="form-horizontal form-validate-jquery">
                    {{csrf_field()}}


                    <fieldset class="content-group">

                        <div class="form-group">
                            <label class="control-label col-lg-2">Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="name" value="{{$item->name ?: old('name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Phone<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="phone" value="{{$item->phone ?: old('phone')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Username<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="username" value="{{$item->username ?: old('username')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Password<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="password" value="{{$item->password ?: old('password')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Door<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="door_id" class="form-control select2" required="required">
                                    {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Door::pluck('name','id')->toArray(), old('door_id', $item->door_id)) !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Day Off<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="day_off" class="form-control select2" required="required">
                                    {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Advisor::$DAYS, old('day_off', $item->day_off)) !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Title<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="title" class="form-control select2" required="required">
                                    {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Advisor::$TITLES, old('title', $item->title)) !!}
                                </select>
                            </div>
                        </div>


                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@stop
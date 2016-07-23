@extends('common.base')

@section('browser_subtitle', 'Wikis')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Wikis Management: {{$item->id ? $item->title : 'Add New'}}</h4></div>
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
                            <label class="control-label col-lg-2">Title</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="title" value="{{$item->title ?: old('title')}}">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Type<span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="type" class="form-control select2" required="required">
                                {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Wiki::$TYPES, old('type', $item->type)) !!}
                            </select>
                        </div>
                    </div>

                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Link</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="link" value="{{$item->link ?: old('link')}}">
                            </div>
                        </div>
                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@stop
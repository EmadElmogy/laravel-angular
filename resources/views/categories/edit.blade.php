@extends('common.base')

@section('browser_subtitle', 'Categories')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Categories Management: {{$item->id ? $item->name : 'Add New'}}</h4></div>
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

                    <fieldset class="content-group">

                        <div class="form-group">
                            <label class="control-label col-lg-2">Brand<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select name="brand" class="form-control select2" required="required">
                                    {!! selectBoxOptionsBuilder([''=>'Please Select']+\App\Category::$BRANDS, old('brand', $item->brand)) !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="name" value="{{$item->name ?: old('name')}}">
                            </div>
                        </div>

                        @if(!$item->id || $item->parent)
                            <div class="form-group">
                                <label class="control-label col-lg-2">Parent Category</label>
                                <div class="col-lg-10">
                                    <select name="parent_id" class="form-control select2">
                                        {!! selectBoxOptionsBuilder(['null'=>'Please Select']+\App\Category::whereNull('parent_id')->pluck('name','id')->toArray(), old('parent_id', $item->parent_id)) !!}
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="control-label col-lg-2">Image</label>
                            <div class="col-lg-3">
                                @if($item->image)
                                    <img src="{{url('uploads/'.$item->image)}}" style="width:100%">
                                @endif
                            </div>
                            <div class="col-lg-7">
                                <input type="file" class="form-control" name="image">
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
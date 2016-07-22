@extends('common.base')

@section('browser_subtitle', 'Product Variations')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Product Variations Management: {{$item->id ? $item->name : 'Add New'}}</h4>
            </div>
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
                            <label class="control-label col-lg-2">Product</label>
                            <div class="col-lg-10">
                                <select name="product_id" class="form-control select2">
                                    {!! selectBoxOptionsBuilder(['null'=>'Please Select']+\App\Product::pluck('name','id')->toArray(), old('product_id', $item->product_id)) !!}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Name<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="name" value="{{$item->name ?: old('name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Barcode<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="barcode" value="{{$item->barcode ?: old('barcode')}}">
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
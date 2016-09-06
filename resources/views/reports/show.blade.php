@extends('common.base')

@section('browser_subtitle', 'Sites')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>{{$item->door->name}} ({{$item->date->toDateString()}})</h4>
                by {{@$item->advisor->name}}
            </div>
        </div>
    </div>

    <div class="content">

        <div class="panel panel-flat">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Barcode</th>
                        <th>SKU</th>
                        <th>Sales</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($item->variations as $item)
                        <tr>
                                {!! Form::open(array('url' => "reports/item/$item->id",'method'=>'PATCH','class'=>'form-horizontal form-validate-jquery','autocomplete'=>'off','role'=>'form')) !!}
                            <input type="hidden" name="report_id" value="{{$item_id}}">
                                {{--{{csrf_field()}}--}}
                            <td class="v-align-middle semi-bold">
                                <input type="text" class="form-control"   name="product" value="{{$item->product->name}}" disabled>
                            </td>
                            <td class="v-align-middle semi-bold">
                                <input type="text" class="form-control"   name="barcode" value="{{$item->barcode}}" disabled>

                            </td>
                                <td class="v-align-middle semi-bold">
                                <input type="text" class="form-control"   name="var_name" value="{{$item->name}}" disabled>

                            </td>
                                <td class="v-align-middle semi-bold">
                                <input type="text" class="form-control"   name="sales" value="{{$item->pivot->sales}}">

                            </td>

                                <td>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary btn-xs">Edit<i class="icon-pencil5 position-right"></i></button>
                                </div>
                                </td>
                            {!! Form::close() !!}


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
@stop

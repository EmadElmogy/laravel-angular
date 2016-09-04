@extends('common.base')

@section('browser_subtitle', 'Customers')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>{{$door->name}} ({{ date('Y-m-d',strtotime($report->date))}})</h4>
                by {{@$advisor_name->name}}
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
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="v-align-middle semi-bold">{{$order->product_name}}</td>
                            <td class="v-align-middle semi-bold">{{$order->barcode}}</td>
                            <td class="v-align-middle semi-bold">{{$order->variation_name}}</td>
                            <td class="v-align-middle semi-bold">{{$order->sales}}</td>
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

@extends('common.base')

@section('browser_subtitle', 'Sites')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>{{$item->door->name}} ({{$item->date->toDateString()}})</h4>
                by {{$item->advisor->name}}
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
                    @forelse($item->variations as $item)
                        <tr>
                            <td class="v-align-middle semi-bold">{{$item->product->name}}</td>
                            <td class="v-align-middle semi-bold">{{$item->barcode}}</td>
                            <td class="v-align-middle semi-bold">{{$item->name}}</td>
                            <td class="v-align-middle semi-bold">{{$item->pivot->sales}}</td>
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
@extends('common.base')

@section('browser_subtitle', 'Reports')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Customer Reports</h4></div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif

                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-2">
                            <select name="filters[door_id]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Door']+\App\Door::pluck('name','id')->toArray(), request('filters.door_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="filters[advisor_id]" class="form-control select2">
                                {!! selectBoxOptionsBuilder([''=>'Advisor']+\App\Advisor::pluck('name','id')->toArray(), request('filters.advisor_id')) !!}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="filters[date]" placeholder="Date" value="{{request('filters.date')}}">
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
                                <th>Date</th>
                                <th>Door</th>
                                <th>Advisor</th>
                                <th>Customer</th>
                                <th>Basket Size</th>
                                <th>Basket Value</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <?php $basket_size=\DB::table('report_products')->where('report_id','=',$item->id)->selectRaw('sum(sales) as sum')->first(); ?>


                                <?php $report_products=\DB::table('report_products')->where('report_id','=',$item->id)->get(); $basket_value=0; ?>
                                @foreach($report_products as $report_product)
                                    <?php $product_variations=\DB::table('variations')->where('id','=',$report_product->variation_id)->first(); ?>
                                            {{--@foreach($product_variations as $product_variation)--}}
                                                <?php $prices=\DB::table('products')->where('id','=',$product_variations->product_id)->first(); ?>
                                                {{--@foreach($prices as $price)--}}
                                                    {{--{{dd($price)}}--}}
                                                    <?php
                                                    $basket_size_items=\DB::table('report_products')->where('report_id','=',$item->id)
                                                                            ->where('variation_id','=',$report_product->variation_id)
                                                                            ->first();
                                                    ?>

                                                    {{--@foreach($basket_size_items as $basket_size_item)--}}
                                                        {{--{{dd($price->price*$basket_size_item->sales)}}--}}
                                                        <?php
                                                        $basket_value=$basket_value+($prices->price*$basket_size_items->sales);
                                                                //dd($basket_value);

                                                        ?>
                                                    {{--@endforeach--}}
                                                    {{--@endforeach--}}
                                            {{--@endforeach--}}

                                    {{--{{dd($basket_size_items->sales)}}--}}
                                @endforeach
                                <tr>
                                    <td class="v-align-middle semi-bold">
                                        <a href="{{url('reports/item/'.$item->id)}}">{{ date('Y-m-d',strtotime($item->date))}}</a>
                                    </td>
                                    <td class="v-align-middle semi-bold">{{@$item->door_name}}</td>
                                    <td class="v-align-middle semi-bold">{{@$item->advisor_name}}</td>
                                    <td class="v-align-middle semi-bold">{{$item1 ? "{$item1->name} ({$item1->mobile})" : ''}}</td>
                                    <td class="v-align-middle semi-bold">{{$basket_size->sum}}</td>
                                    <td class="v-align-middle semi-bold">{{$basket_value}}</td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="{{url('customers/item/'.$item1->id)}}" class="btn btn-primary btn-xs"><i class="icon-file-eye"></i></a>
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

                {!!$items->render()!!}

            </div>
        </div>

    </div>

@stop


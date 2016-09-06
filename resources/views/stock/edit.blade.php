@extends('common.base')

@section('browser_subtitle', 'stock')

@section('body')

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Stock</h4></div>
        </div>
    </div>

    <div class="content">
        <div class="row mb-20">
            <form action="">


                <div class="col-md-2">
                    <select name="filters[barcode]" class="form-control select2">
                        {!! selectBoxOptionsBuilder([''=>'Barcode']+\App\Variation::pluck('barcode','id')->toArray(), request('filters.barcode')) !!}
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="filters[product_id]" class="form-control select2">
                        {!! selectBoxOptionsBuilder([''=>'Product']+\App\Product::pluck('name','id')->toArray(), request('filters.product_id')) !!}
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-info btn-sm">
                        <i class="icon-filter3 position-left"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                @endif


                <form role="form" method="post" autocomplete="off">
                    {{csrf_field()}}
                    <div class="panel panel-flat">

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td class="v-align-middle semi-bold">
                                            {{$item->product->category->name}} > {{$item->product->name}} > {{$item->name}}
                                        </td>
                                        <td>{{$item->barcode}}</td>
                                        <td>
                                            <input type="text" class="form-control"
                                                   name="variation[{{$item->id}}]"
                                                   value="{{ @$stock->where('variation_id', $item->id)->where('door_id', $door->id)->first()->stock ?: 0}}">
                                        </td>
                                    </tr>

                                    @if(@$stock->where('variation_id', $item->id)->where('door_id', $door->id)->first()->stock < 3)
                                         <?php
                                               /*       
                                         $emails=\App\Setting::whereKey('reports_emails')->first()->value;
                                         $quantity=$stock->where('varia1tion_id', $item->id)->where('door_id', $door->id)->first()->stock;
                                         $variation_stocks=\DB::table('variations_stock')
                                                 ->where('stock','<','3')
                                                 ->join('doors','variations_stock.door_id','=','doors.id')
                                                 ->join('variations','variations_stock.variation_id','=','variations.id')
                                                 ->select('*','doors.name as door_name','variations.name as variation_name')
                                                 ->get();
                                              if($variation_stocks) {
                                         $string = str_replace(' ', '"', $emails); // Replaces all spaces with hyphens.
                                        $emails_trimmed= preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                                            //dd($emails_trimmed);
                                         $matches = array();
                                         $pattern = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
                                         $emails_clair=preg_match_all($pattern,$emails,$matches);
                                                 //$matches_str=implode(",",$matches);
                                                 //$wew=unserialize($matches_str);
                                                //dd($matches[0]);
                                         \Mail::send('emails.email', ['variation_stocks'=>$variation_stocks], function ($m) use ($item,$matches) {
                                             $m->from('mobile@bluecrunch.com', "Out of Stock {{$item->product->name}} ");
                                                foreach ($matches[0] as $match){
                                             $m->to($match)->subject("Out of Stock {{$item->product->name}} ");
                                                    }

                                         });
                                        // var_dump( \Mail:: failures()); exit;
                                                } */
                                          ?>
                                        @endif

                                @empty
                                    <tr>
                                        <td colspan="41" class="text-center">No records were found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

@stop

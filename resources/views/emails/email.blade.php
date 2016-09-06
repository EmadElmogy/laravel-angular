/*@foreach($variation_stocks as $variation_stock)
    <?php $product=\DB::table('products')->where('id','=',$variation_stock->product_id)->first(); ?>
  Product : {{$product->name}} ,
    In Door : {{$variation_stock->door_name}} is out of stock ,
    its Quantity : {{$variation_stock->stock}} . <br>


    @endforeach */

{{dd($variation_stocks)}}

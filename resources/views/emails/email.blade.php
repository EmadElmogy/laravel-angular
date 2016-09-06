

 @foreach($variation_stocks as $variation_stock)
     Product : {{$variation_stock->product_name}} <br>
     Sku : {{$variation_stock->barcode}} <br>
     Door : {{$variation_stock->door_name}} <br>
     Current Stock : {{$variation_stock->stock}}

     @endforeach
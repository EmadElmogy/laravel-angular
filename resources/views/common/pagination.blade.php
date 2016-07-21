<div class="row">
    <div class="col-sm-6">
        {{ sprintf(trans('foodics.pagination'), $items->firstItem(), $items->lastItem(), $items->total())  }}
    </div>
    <div class="col-sm-6 text-right">
        {!!$items->render()!!}
    </div>
</div>
<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class VariationTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['product_id', 'pivot']);

        if ($this->isLoadedFromPivotTable($item, 'report_products')) {
            $output['sales'] = (int) $item->pivot->sales;
        }

        return $output;
    }

}
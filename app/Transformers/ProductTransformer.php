<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class ProductTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['category_id', 'variations']);

        $output['image'] = url('uploads/'.$item->image);

        if ($this->isRelationshipLoaded($item, 'category')) {
            $output['category'] = CategoryTransformer::transform($item->category);
        }

        if ($this->isRelationshipLoaded($item, 'variations')) {
            $output['variations'] = VariationTransformer::transform($item->variations);
        }

        return $output;
    }

}
<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class CategoryTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['parent_id', 'children']);

        $output['image'] = url('uploads/'.$item->image);

        $output['brand'] = [
            'name' => $item->brandName,
            'id' => $item->brand,
        ];

        if ($this->isRelationshipLoaded($item, 'children')) {
            $output['sub_categories'] = transform($item->children);
        }

        return $output;
    }

}
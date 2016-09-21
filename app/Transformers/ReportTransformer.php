<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class ReportTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['door_id', 'advisor_id', 'variations', 'customer_id']);

        if ($this->isRelationshipLoaded($item, 'door')) {
            $output['door'] = DoorTransformer::transform($item->door);
        }

        if ($this->isRelationshipLoaded($item, 'advisor')) {
            $output['advisor'] = AdvisorTransformer::transform($item->advisor);
        }

        if ($this->isRelationshipLoaded($item, 'customer')) {
            $output['customer'] = CustomerTransformer::transform($item->customer);
        }

        if ($this->isRelationshipLoaded($item, 'variations')) {
            $output['product_variations'] = VariationTransformer::transform($item->variations);
        }

        return $output;
    }

}
<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class ComplainTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['door_id', 'advisor_id']);

        if ($this->isRelationshipLoaded($item, 'door')) {
            $output['door'] = transform($item->door);
        }

        if ($this->isRelationshipLoaded($item, 'advisor')) {
            $output['advisor'] = AdvisorTransformer::transform($item->advisor);
        }

        return $output;
    }

}
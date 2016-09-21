<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class DoorTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['site_id']);

        if ($this->isRelationshipLoaded($item, 'site')) {
            $output['site'] = transform($item->site);
        }

        return $output;
    }

}
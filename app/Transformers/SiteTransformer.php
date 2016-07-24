<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class SiteTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), []);

        if ($this->isRelationshipLoaded($item, 'doors')) {
            $output['doors'] = DoorTransformer::transform($item->doors);
        }

        return $output;
    }

}
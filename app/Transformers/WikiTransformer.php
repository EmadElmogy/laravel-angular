<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class WikiTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), []);

        $output['type'] = [
            'name' => $item->typeName,
            'id' => $item->type,
        ];


        return $output;
    }

}
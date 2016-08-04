<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class CustomerTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = $item->toArray();

        return $output;
    }

}
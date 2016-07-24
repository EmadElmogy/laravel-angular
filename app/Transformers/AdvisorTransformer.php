<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class AdvisorTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), []);

        $output['day_off'] = [
            'name' => $item->dayName,
            'id' => $item->day_off,
        ];

        $output['title'] = [
            'name' => $item->titleName,
            'id' => $item->title,
        ];

        return $output;
    }

}
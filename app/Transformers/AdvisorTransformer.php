<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class AdvisorTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = array_except($item->toArray(), ['door_id']);

        if($item->day_off){
            $output['day_off'] = [
                'name' => $item->dayName,
                'id' => $item->day_off,
            ];
        }
        
        if($item->title){
            $output['title'] = [
                'name' => $item->titleName,
                'id' => $item->title,
            ];
        }

        if ($this->isRelationshipLoaded($item, 'door')) {
            $output['door'] = DoorTransformer::transform($item->door);
        }

        return $output;
    }

}
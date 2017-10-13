<?php

namespace App\Repos;

use App\Apartment;
use App\Filter;
use Illuminate\Database\Eloquent\Model;

class ApartmentsRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Apartment();
    }

    /**
     * @param $filters
     *
     * @return Model
     *
     * @internal param $idOrModel
     */
    protected function filter($filters)
    {
        $filters = $this->prepareFilters($filters);

        $query = $this->model;

        return $query->where($filters);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        $data['apartment_token'] = str_random(40);

        return parent::create($data);
    }
}

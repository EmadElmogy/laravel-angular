<?php

namespace App\Repos;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Customer();
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
        return parent::create($data);
    }
}
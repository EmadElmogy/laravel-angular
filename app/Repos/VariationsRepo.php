<?php

namespace App\Repos;

use App\Filter;
use App\Variation;
use Illuminate\Database\Eloquent\Model;

class VariationsRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Variation();
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
        $query = $this->model;
        $filters = $this->prepareFilters($filters);
        $filter = Filter::create($query, $filters);

        $query = $filter
            ->fuzzy('name')
            ->end();

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

    /**
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model|null $item
     * @throws \App\Exceptions\ValidationException
     */
    public function prepareData($data, $item = null)
    {
        validate($data, ['barcode' => 'required|unique:variations,barcode'.($item ? ",$item->id" : '')]);

        return $data;
    }
}
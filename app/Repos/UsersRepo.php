<?php

namespace App\Repos;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new User();
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

    /**
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model|null $item
     * @throws \App\Exceptions\ValidationException
     */
    public function prepareData($data, $item = null)
    {
        validate($data, ['email' => 'required|unique:users,email'.($item ? ",$item->id" : '')]);

        return $data;
    }
}
<?php

namespace App\Repos;

use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

abstract class AbstractRepo
{
    /**
     * @var Model|Builder
     */
    public $model;

    /**
     * @param $data
     *
     * @return Model
     */
    public function create($data)
    {
        $data = $this->prepareData($data);

        validate($data, $this->model->validationRules);

        $item = $this->model->create($data);

        return $item;
    }

    /**
     * @param $idOrModel
     * @param $data
     *
     * @return Model
     *
     * @throws \App\Exceptions\ValidationException
     */
    public function update($idOrModel, $data)
    {
        $item = $this->getItem($idOrModel);

        if (! $item || ! $item->id) {
            return $this->create($data);
        }

        $data = $this->prepareData($data, $item);

        validate($data, $this->model->validationRules, true);

        $item->update($data);

        return $item;
    }

    /**
     * Get all records.
     *
     * @param array $filters
     * @param array $with
     * @param bool $returnResults return results collection if true, query object if false
     *
     * @return Collection|Builder
     */
    public function findAll($filters = [], $with = [], $returnResults = true)
    {
        $query = $this->filter($filters)
            ->with($with)
            ->orderBy('id', 'DESC');

        return $returnResults ? $query->get() : $query;
    }

    /**
     * Find a record by a specific key.
     *
     * @param $filters
     * @param array $with
     *
     * @return mixed|static
     */
    public function findOneBy($filters = [], $with = [])
    {
        return $this->filter($filters)->with($with)->first();
    }

    /**
     * Find a record by a specific key of Fail.
     *
     * @param array $filters
     * @param array $with
     *
     * @return Model
     */
    public function findOneByOrFail($filters = [], $with = [])
    {
        return $this->model->where($filters)->with($with)->firstOrFail();
    }

    /**
     * Delete a record by id.
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $idOrModel
     *
     * @return Model
     */
    protected function getItem($idOrModel)
    {
        return gettype($idOrModel) == 'object' ? $idOrModel : $this->model->find($idOrModel);
    }

    /**
     * @param $filters
     *
     * @return array
     */
    protected function prepareFilters($filters)
    {
        // Neglect empty values
        $filters = array_filter($filters, function ($item, $key) {
            return $key == 'id' || $item != '' ? true : false;
        }, ARRAY_FILTER_USE_BOTH);

        return $filters;
    }

    /**
     * @param $filters
     *
     * @return Model
     */
    protected function filter($filters)
    {
        $filters = $this->prepareFilters($filters);

        return $this->model->where($filters);
    }

    /**
     * @param array $data
     * @param null|Model $item
     *
     * @return mixed
     */
    protected function prepareData($data, $item = null)
    {
        return $data;
    }
}

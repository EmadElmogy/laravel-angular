<?php

namespace App\Repos;

use App\Contact;
use App\Filter;
use Illuminate\Database\Eloquent\Model;

class ContactsRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Contact();
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
        $data['contact_token'] = str_random(40);

        return parent::create($data);
    }

    /**
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model|null $item
     * @throws \App\Exceptions\ValidationException
     */
    public function prepareData($data, $item = null)
    {
        validate($data, ['email' => 'required|unique:contacts,email'.($item ? ",$item->id" : '')]);

        return $data;
    }
}

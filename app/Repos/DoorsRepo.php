<?php

namespace App\Repos;

use App\Door;
use App\Exceptions\SystemException;
use Illuminate\Database\Eloquent\Model;

class DoorsRepo extends AbstractRepo
{
    public function __construct()
    {
        $this->model = new Door();
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
     * @param $id
     *
     * @return int
     *
     * @throws SystemException
     */
    public function delete($id)
    {
        $item = $this->findOneByOrFail(['id' => $id]);

        if ($item->doors()->count('id')) {
            throw new SystemException('Site can not be removed because it has doors.');
        }

        return parent::delete($id);
    }
}
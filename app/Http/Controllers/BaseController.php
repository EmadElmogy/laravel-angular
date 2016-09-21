<?php

namespace App\Http\Controllers;

use App\Exceptions\SystemException;
use App\Repos\AbstractRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @var AbstractRepo
     */
    public $repo;

    /**
     * @param $repo
     * @param $item_id
     *
     * @return Model
     */
    public function bringOrNew(AbstractRepo $repo, $item_id)
    {
        return $item_id ? $repo->findOneByOrFail(['id' => $item_id]) : $repo->model;
    }

    /**
     * @param Request $request
     * @param null $item_id
     *
     * @return \Illuminate\View\View
     */
    public function deleteItem(Request $request, $item_id = null)
    {
        try {
            $this->repo->delete($item_id);
        } catch (SystemException $e) {
            return response([
                'data' => $e->getMessage(),
                'errors' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            return response([
                'data' => app()->environment('production') ? 'Item cannot be deleted!' : $e->getMessage(),
                'errors' => $e->getMessage(),
            ], 500);
        }

        return response(['data' => 'Item deleted successfully!', 'errors' => null], 200);
    }
}

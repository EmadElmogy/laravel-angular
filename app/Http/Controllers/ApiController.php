<?php

namespace App\Http\Controllers;

use App\Advisor;
use App\Category;
use App\Complain;
use App\Product;
use App\Report;
use App\Site;
use App\Transformers\AdvisorTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\ComplainTransformer;
use App\Transformers\ProductTransformer;
use App\Transformers\ReportTransformer;
use App\Transformers\SiteTransformer;
use App\Transformers\WikiTransformer;
use App\Wiki;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\ValidationException
     */
    public function login()
    {
        validate(request()->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $advisor = Advisor::where(request()->only('username', 'password'))->with('door')->first();

        if (! $advisor) {
            return response('Unauthorized.', 401);
        }

        $advisor->attendance()->whereNull('logout_time')->update(['logout_time' => Carbon::now()]);

        $advisor->attendance()->create([
            'login_time' => Carbon::now(),
            'door_id' => $advisor->door_id,
        ]);

        return response([
            'advisor' => AdvisorTransformer::transform($advisor)
        ]);
    }

    /**
     *
     */
    public function logout()
    {
        auth()->guard('api')->user()->attendance()->whereNull('logout_time')->update([
            'logout_time' => Carbon::now(),
            'door_id' => auth()->guard('api')->user()->door_id
        ]);

        auth()->guard('api')->user()->update([
            'api_token' => str_random(40)
        ]);

        return response(['logged_out' => true]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sites()
    {
        return response([
            'sites' => SiteTransformer::transform(Site::with('doors')->get())
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function categories()
    {
        return response([
            'categories' => CategoryTransformer::transform(Category::whereNull('parent_id')->with('children')->get())
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function products()
    {
        return response([
            'products' => ProductTransformer::transform(
                Product::with('variations')
                    ->when(request('category_id'), function ($q) {
                        return $q->where('category_id', request('category_id'));
                    })
                    ->get()
            )
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function wiki()
    {
        return response([
            'categories' => WikiTransformer::transform(Wiki::all())
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function complains()
    {
        $filters = array_filter(request()->only(['date', 'door_id', 'advisor_id']));

        return response([
            'complains' => ComplainTransformer::transform(
                Complain::where($filters)
                    ->orderBy('date', 'DESC')
                    ->with([
                        'door',
                        'advisor' => function ($q) {
                            $q->select('id', 'name');
                        }
                    ])->get()
            )
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\ValidationException
     */
    public function newComplain()
    {
        validate(request()->all(), ['comment' => 'required']);

        $item = Complain::create(
            [
                'comment' => request('comment'),
                'advisor_id' => auth()->guard('api')->user()->id,
                'door_id' => auth()->guard('api')->user()->door_id,
                'date' => Carbon::now()->toDateTimeString()
            ]
        );

        $item->load([
            'advisor' => function ($q) {
                $q->select('id', 'name');
            },
            'door'
        ]);

        return response([
            'complain' => ComplainTransformer::transform($item)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function reports()
    {
        $filters = array_filter(request()->only(['door_id', 'advisor_id']));

        return response([
            'reports' => ReportTransformer::transform(
                Report::where($filters)
                    ->when(request('date'), function ($q) {
                        return $q->whereDate('date', '=', request('date'));
                    })
                    ->orderBy('date', 'DESC')
                    ->with([
                        'door',
                        'advisor' => function ($q) {
                            $q->select('id', 'name');
                        }
                    ])->get()
            )
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function report($report_id)
    {
        return response([
            'report' => ReportTransformer::transform(
                Report::whereId($report_id)
                    ->with([
                        'door',
                        'variations.product',
                        'advisor' => function ($q) {
                            $q->select('id', 'name');
                        }
                    ])->firstOrFail()
            )
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\ValidationException
     */
    public function newReport()
    {
        validate(request()->all(), [
            'product_variations' => 'required|array|min:1',
            'product_variations.*.variation_id' => 'required|exists:variations,id',
            'product_variations.*.sales' => 'required|numeric',
        ]);

        $item = Report::create(
            [
                'advisor_id' => auth()->guard('api')->user()->id,
                'door_id' => auth()->guard('api')->user()->door_id,
                'date' => Carbon::now()->toDateTimeString()
            ]
        );

        foreach (request('product_variations') as $variation) {
            $item->variations()->attach($variation['variation_id'], [
                'sales' => $variation['sales']
            ]);
        }

        $item->load([
            'advisor' => function ($q) {
                $q->select('id', 'name');
            },
            'door',
            'variations.product',
        ]);

        return response([
            'report' => ReportTransformer::transform($item)
        ]);
    }
}

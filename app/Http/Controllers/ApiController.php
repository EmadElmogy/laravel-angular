<?php

namespace App\Http\Controllers;

use App\Advisor;
use App\Category;
use App\Complain;
use App\Customer;
use App\Product;
use App\Report;
use App\Attendance;
use App\Door;
use App\Site;
use App\Transformers\AdvisorTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\ComplainTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\ProductTransformer;
use App\Transformers\ReportTransformer;
use App\Transformers\SiteTransformer;
use App\Transformers\WikiTransformer;
use App\Wiki;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        //dd($advisor->id);
        if (! $advisor) {
            return response('Unauthorized.', 401);
        }

        $advisor->attendance()->whereNull('logout_time')->update(['logout_time' => Carbon::now()]);

        $advisor->attendance()->create([
            'login_time' => Carbon::now(),
            'door_id' => $advisor->door_id,
        ]);
       $door=Door::find($advisor->door_id);

            $door_lat=$door->door_lat;
            $door_lng=$door->door_lng;
            if ($door_lng === request()->lng && $door_lat === request()->lat){
               // echo "equal"; die;
                $advisor->attendance()->where('advisor_id','=',$advisor->id)->update(['sign_in_range' => '1']);
            }elseif ($door_lng === "0" && $door_lat === "0"){
                $advisor->attendance()->where('advisor_id','=',$advisor->id)->update(['sign_in_range' => '2']);
            }elseif ($door_lng != request()->lng || $door_lat != request()->lat){
                $advisor->attendance()->where('advisor_id','=',$advisor->id)->update(['sign_in_range' => '0']);
            }


        return response([
            'advisor' => AdvisorTransformer::transform($advisor),
            /*'lng'=>request()->lng,
            'lat'=>request()->lat,*/
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


        $door=Door::find(auth()->guard('api')->user()->door_id);

        $door_lat=$door->door_lat;
        $door_lng=$door->door_lng;
        //dd(auth()->guard('api')->user());
        if ($door_lng === request()->lng && $door_lat === request()->lat){
            // echo "equal"; die;
            auth()->guard('api')->user()->attendance()->where('advisor_id','=',auth()->guard('api')->user()->id)->update(['sign_out_range' => '1']);
        }elseif ($door_lng === "0" && $door_lat === "0"){
            auth()->guard('api')->user()->attendance()->where('advisor_id','=',auth()->guard('api')->user()->id)->update(['sign_out_range' => '2']);
        }elseif ($door_lng != request()->lng || $door_lat != request()->lat){
            auth()->guard('api')->user()->attendance()->where('advisor_id','=',auth()->guard('api')->user()->id)->update(['sign_out_range' => '0']);
        }


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
        $skip = request('skip', 0);
        $take = request('per_page', 100);

        return response([
            'categories' => CategoryTransformer::transform(Category::whereNull('parent_id')
                ->with('children')
                ->skip($skip)
                ->take($take)
                ->get())
        ]);
    }

    public function brand_categories($brand_id){
        $skip = request('skip', 0);
        $take = request('per_page', 100);
        return response([
            'categories' => CategoryTransformer::transform(
                Category::whereNull('parent_id')
                    ->with('children')
                    ->whereId($brand_id)
                    ->skip($skip)
                    ->take($take)
                    ->get())
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function products()
    {
        $skip = request('skip', 0);
        $take = request('per_page', 100);

        return response([
            'products' => ProductTransformer::transform(
                Product::with('variations')
                    ->when(request('category_id'), function ($q) {
                        return $q->where('category_id', request('category_id'));
                    })
                    ->skip($skip)
                    ->take($take)
                    ->get()
            )
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function wiki()
    {
        $skip = request('skip', 0);
        $take = request('per_page', 100);

        return response([
            'categories' => WikiTransformer::transform(Wiki::skip($skip)
                ->take($take)->get())
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
        validate(request()->all(), (new Complain)->validationRules);

        $item = Complain::create(
            [
                'image' => request('image'),
                'type' => request('type'),
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
    public function customers()
    {
        return response([
            'customers' => CustomerTransformer::transform(
                Customer::select('*')
                    ->when(request('mobile'), function ($q) {
                        return $q->where('mobile', 'LIKE', '%'.request('mobile').'%');
                    })
                    ->get()
            )
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

        $newCustomerData = request('new_customer');

        $customer = request('customer_id')
            ? Customer::findOrFail(request('customer_id'))
            : ($newCustomerData ? Customer::create(request('new_customer')) : null);

        $item = Report::create(
            [
                'customer_id' => $customer ? $customer->id : null,
                'advisor_id' => auth()->guard('api')->user()->id,
                'door_id' => auth()->guard('api')->user()->door_id,
                'date' => Carbon::now()->toDateTimeString()
            ]
        );

        $doorId = auth()->guard('api')->user()->door_id;

        foreach (request('product_variations') as $variation) {
            $item->variations()->attach($variation['variation_id'], [
                'sales' => $variation['sales']
            ]);

            $record = DB::table('variations_stock')->where([
                'variation_id' => $variation['variation_id'],
                'door_id' => $doorId,
            ]);

            if ($current = $record->first()) {
                $record->update([
                    'stock' => $current->stock - $variation['sales']
                ]);
            }
        }

        $item->load([
            'advisor' => function ($q) {
                $q->select('id', 'name');
            },
            'door',
            'customer',
            'variations.product',
        ]);

        $record2 = DB::table('variations_stock')->where([
            'variation_id' => $variation['variation_id'],
            'door_id' => $doorId,
            ])
            ->join('doors','variations_stock.door_id','=','doors.id')
            ->join('variations','variations_stock.variation_id','=','variations.id')
            ->join('products','variations.product_id','=','products.id')->select('*','doors.name as door_name','products.name as product_name','variations.name as variation_name');
       // die;
         if ($record->first()->stock <= 3) {
             $emails = \App\Setting::whereKey('reports_emails')->first()->value;
             //$quantity = $record->stock;
             /*$variation_stocks=\DB::table('variations_stock')
                 ->where('stock','<','3')
                 ->join('doors','variations_stock.door_id','=','doors.id')
                 ->join('variations','variations_stock.variation_id','=','variations.id')
                 ->select('*','doors.name as door_name','variations.name as variation_name')
                 ->get();*/
             $variation_stocks=$record2->get();
             if ($variation_stocks) {
                 $string = str_replace(' ', '"', $emails); // Replaces all spaces with quotes.
                 $emails_trimmed = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
                 //dd($emails_trimmed);
                 $matches = array();
                 $pattern = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
                 $emails_clair = preg_match_all($pattern, $emails, $matches);
                 \Mail::send('emails.email', ['variation_stocks' => $variation_stocks], function ($m) use ($item, $matches) {
                     $m->from('mobile@bluecrunch.com', "Stock Notification Alert");
                     foreach ($matches[0] as $match) {
                         $m->to($match)->subject("Stock Notification Alert");
                     }

                 });
                 // var_dump( \Mail:: failures()); exit;
             }
         }
        return response([
            'report' => ReportTransformer::transform($item)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\ValidationException
     */
    public function stock()
    {
        validate(request()->all(), [
            'product_variations' => 'required|array|min:1',
            'product_variations.*.variation_id' => 'required|exists:variations,id',
            'product_variations.*.stock' => 'required|numeric',
        ]);

        $doorId = auth()->guard('api')->user()->door_id;

        foreach (request('product_variations') as $variation) {
            $record = DB::table('variations_stock')->where([
                'variation_id' => $variation['variation_id'],
                'door_id' => $doorId,
            ]);

            if ($current = $record->first()) {
                $record->update([
                    'stock' => $variation['stock'] + $current->stock
                ]);
            } else {
                DB::table('variations_stock')->insert([
                    'variation_id' => $variation['variation_id'],
                    'door_id' => $doorId,
                    'stock' => $variation['stock'],
                ]);
            }
        }

        return response([
            'success' => true
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\ValidationException
     */
    public function newCustomer()
    {
        validate(request()->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        $customer = Customer::create(
            array_only(request()->json()->all(), ['name', 'email', 'mobile', 'area'])
        );

        return response([
            'customer' => CustomerTransformer::transform($customer)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function brands()
    {
        return response([
            'brands' => collect(Category::$BRANDS)->map(function ($item, $key) {
                return (object) [
                    'id' => $key,
                    'name' => $item,
                    'image' => Category::$BRANDIMAGES[$key],
                ];
            })->values()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Offers;
use DB;
use File;
use Illuminate\Database\QueryException;
use App\Hotels;
use App\Actives;
use App\Restaurants;
use Illuminate\Http\Request;
use App\Http\Requests\RestaurantsRequest;

class RestaurantsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'store',
            //'searchRestaurant',
            'edit',
            'update',
            'destroy'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $hotels = Hotels::orderBy('hotel_name', 'ASC')->where('active_id', '1')->get();
            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('restaurant.index', [
                'hotels' => $hotels,
                'actives' => $actives
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();

            $restaurants = DB::table('restaurants')
                ->select('restaurants.id', 'restaurant_name', 'hotel_name', 'restaurant_email', 'actives.active', 'restaurant_comment')
                ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->orderBy('restaurants.id', 'asc')->paginate(10);
            return view('restaurant.list', [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'restaurants' => $restaurants
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantsRequest $request)
    {
        DB::beginTransaction();
        try {
            $restaurants = new Restaurants;
            $restaurants->restaurant_name = $request->restaurant_name;
            $restaurants->restaurant_email = $request->restaurant_email;
            $restaurants->hotel_id = $request->hotel_id;
            $restaurants->active_id = $request->active_id;
            $restaurants->restaurant_comment = $request->restaurant_comment;
            $restaurants->save();
            DB::commit();
            return redirect()->action('RestaurantsController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function searchRestaurant(Request $request)
    {
        try {
            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();
            $where = null;

            if ($request->search_value == 'hotel') {
                $where = ['restaurants.hotel_id' => $request->hotel_id];
            } else {
                $where = ['restaurants.id' => $request->restaurant_id];
            }

            $restaurants = DB::table('restaurants')
                ->select('restaurants.id', 'restaurant_name', 'hotel_name', 'restaurant_email', 'actives.active', 'restaurant_comment')
                ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->where($where)->get();
            return view('restaurant.search', [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'restaurants' => $restaurants
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*try {
            $restaurants = Restaurants::find($id);
            if ($restaurants->pdf_name != null) {
                return response()->file(public_path('pdf/' . $restaurants->pdf_name));
            } else {
                return view('error.index')->with('error', 'File PDF not found');
            }
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        }*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $restaurants = DB::table('restaurants')
                ->select('restaurants.id', 'restaurant_name', 'restaurant_email', 'restaurants.hotel_id', 'hotel_name', 'restaurants.active_id', 'actives.active', 'restaurant_comment')
                ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->orderBy('restaurants.id', 'asc')->where('restaurants.id', $id)->first();

            $actives = Actives::orderBy('id', 'ASC')->get();
            $hotels = Hotels::orderBy('hotel_name', 'ASC')->where('active_id', '1')->get();

            return view('restaurant.edit', [
                'id' => $restaurants->id,
                'restaurant_name' => $restaurants->restaurant_name,
                'restaurant_email' => $restaurants->restaurant_email,
                'hotel_id' => $restaurants->hotel_id,
                'hotel_name' => $restaurants->hotel_name,
                'active_id' => $restaurants->active_id,
                'active' => $restaurants->active,
                'restaurant_comment' => $restaurants->restaurant_comment
            ])->with('actives', $actives)->with('hotels', $hotels);

        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantsRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('restaurants')
                ->where('id', $id)
                ->update([
                    'restaurant_name' => $request->restaurant_name,
                    'restaurant_email' => $request->restaurant_email,
                    'hotel_id' => $request->hotel_id,
                    'active_id' => $request->active_id,
                    'restaurant_comment' => $request->restaurant_comment
                ]);
            DB::commit();
            if (Offers::select('hotel_id')->where('restaurant_id', $id)->exists()) {
                //Found hotel_id  in  set_menus
                DB::table('offers')->where('restaurant_id', $id)
                    ->update([
                        'hotel_id' => $request->hotel_id
                    ]);
                DB::commit();
                return redirect()->action('RestaurantsController@create');
            } else {
                return redirect()->action('RestaurantsController@create');
            }
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('restaurants')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('RestaurantsController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }
}

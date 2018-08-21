<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\ActionLog;
use App\Offers;
use Illuminate\Database\QueryException;
use App\Hotels;
use App\Actives;
use Carbon\Carbon;
use App\Restaurants;
use Illuminate\Http\Request;
use App\Http\Requests\RestaurantsRequest;
use Illuminate\Support\Facades\Auth;

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

        $GLOBALS['controller'] = 'RestaurantsController';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotels = $this->GetHotelsItems();
                $actives = $this->GetActivesItems();
                return view('restaurant.index', [
                    'hotels' => $hotels,
                    'actives' => $actives
                ]);
            }

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

            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotel_items = $this->GetHotelsItems();
                $restaurant_items = $this->GetRestaurantsItems();
                $restaurants = DB::table('restaurants')
                    ->select('restaurants.id', 'restaurant_name', 'hotel_name', 'restaurant_email', 'restaurant_phone', 'actives.active', 'restaurant_comment')
                    ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                    ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                    ->where('restaurants.active_id', 1)->orderBy('restaurants.id', 'asc')->paginate(10);
                return view('restaurant.list', [
                    'hotel_items' => $hotel_items,
                    'restaurant_items' => $restaurant_items,
                    'restaurants' => $restaurants
                ]);
            }
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
            $restaurants->restaurant_phone = $request->restaurant_phone;
            $restaurants->hotel_id = $request->hotel_id;
            $restaurants->active_id = $request->active_id;
            $restaurants->restaurant_comment = $request->restaurant_comment;
            $restaurants->save();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

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
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotel_items = $this->GetHotelsItems();
                $restaurant_items = $this->GetRestaurantsItems();
                $where = null;

                if ($request->search_value == 'hotel') {
                    $where = ['restaurants.hotel_id' => $request->hotel_id, 'restaurants.active_id' => 1];
                } else {
                    $where = ['restaurants.id' => $request->restaurant_id, 'restaurants.active_id' => 1];
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
            }

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

            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $actives = $this->GetActivesItems();
                $hotels = $this->GetHotelsItems();
                $restaurants = DB::table('restaurants')
                    ->select('restaurants.id', 'restaurant_name', 'restaurant_email', 'restaurant_phone', 'restaurants.hotel_id', 'hotel_name', 'restaurants.active_id', 'actives.active', 'restaurant_comment')
                    ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                    ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                    ->orderBy('restaurants.id', 'asc')->where('restaurants.id', $id)->first();

                return view('restaurant.edit', [
                    'id' => $restaurants->id,
                    'restaurant_name' => $restaurants->restaurant_name,
                    'restaurant_email' => $restaurants->restaurant_email,
                    'restaurant_phone' => $restaurants->restaurant_phone,
                    'hotel_id' => $restaurants->hotel_id,
                    'hotel_name' => $restaurants->hotel_name,
                    'active_id' => $restaurants->active_id,
                    'active' => $restaurants->active,
                    'restaurant_comment' => $restaurants->restaurant_comment
                ])->with('actives', $actives)->with('hotels', $hotels);
            }

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
                    'restaurant_phone' => $request->restaurant_phone,
                    'hotel_id' => $request->hotel_id,
                    'active_id' => $request->active_id,
                    'restaurant_comment' => $request->restaurant_comment,
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

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
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);

            DB::commit();
            return redirect()->action('RestaurantsController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param $user_id
     * @param $controller
     * @param $function
     * @param $action_id
     */
    public function SaveLog($user_id, $controller, $function, $action_id)
    {
        $action = new ActionLog;
        $action->user_id = $user_id;
        $action->controller = $controller;
        $action->function = $function;
        $action->action_id = $action_id;
        $action->save();
    }

    /**
     * @return mixed
     */
    public function GetRestaurantsItems()
    {
        return Restaurants::select('id', 'restaurant_name')->where('restaurants.active_id', 1)->orderBy('restaurant_name', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetHotelsItems()
    {
        return Hotels::select('id', 'hotel_name')->where('hotels.active_id', 1)->orderBy('hotel_name', 'ASC')->get();
    }


    /**
     * @return mixed
     */
    public function GetActivesItems()
    {
        return Actives::orderBy('id', 'ASC')->get();
    }
}

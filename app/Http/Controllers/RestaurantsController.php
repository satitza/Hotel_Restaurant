<?php

namespace App\Http\Controllers;

use DB;
use App\Hotels;
use App\Actives;
use App\Restaurants;
use Illuminate\Http\Request;

class RestaurantsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $hotels = Hotels::orderBy('hotel_name', 'ASC')->where('active', '1')->get();
            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('restaurant.index', [
                'hotels' => $hotels,
                'actives' => $actives
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        try {
            $restaurants = DB::table('restaurants')
                            ->select('restaurants.id', 'restaurant_name', 'hotel_name', 'actives.active', 'restaurant_comment')
                            ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                            ->join('actives', 'restaurants.active', '=', 'actives.id')
                            ->orderBy('restaurants.id', 'asc')->where('restaurants.active', '1')->paginate(10);
            return view('restaurant.list', [
                'restaurants' => $restaurants
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $restaurants = new Restaurants;
            $restaurants->restaurant_name = $request->restaurant_name;
            $restaurants->hotel_id = $request->hotel_id;
            $restaurants->active = $request->active_id;
            $restaurants->restaurant_comment = $request->restaurant_comment;
            $restaurants->save();
            DB::commit();
            return redirect()->action('RestaurantsController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        try {
            $restaurants = DB::table('restaurants')
                            ->select('restaurants.id', 'restaurant_name', 'hotel_name', 'actives.active', 'restaurant_comment')
                            ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                            ->join('actives', 'restaurants.active', '=', 'actives.id')
                            ->orderBy('restaurants.id', 'asc')->where('restaurants.id', $id)->get();
            foreach ($restaurants as $restaurant) {
                
            }

            $actives = Actives::orderBy('id', 'ASC')->get();
            $hotels = Hotels::orderBy('id', 'ASC')->where('active', '1')->get();

            return view('restaurant.edit', [
                        'id' => $restaurant->id,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'hotel_name' => $restaurant->hotel_name,
                        'active' => $restaurant->active,
                        'restaurant_comment' => $restaurant->restaurant_comment
                    ])->with('actives', $actives)->with('hotels', $hotels);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //echo $id."<br>";
        //echo $request->restaurant_name."<br>";
        //echo $request->hotel_id."<br>";
        //echo $request->active_id."<br>";
        //echo $request->restaurant_comment."<br>";
        if ($request->hotel_id == "please_selected_hotel") {
            return view('error.index')->with('error', 'Please selected hotel');
        } elseif ($request->active_id == "please_selected_active") {
            return view('error.index')->with('error', 'Please selected active');
        } else {
            DB::beginTransaction();
            try {
                DB::table('restaurants')
                        ->where('id', $id)
                        ->update([
                            'restaurant_name' => $request->restaurant_name,
                            'hotel_id' => $request->hotel_id,
                            'active' => $request->active_id,
                            'restaurant_comment' => $request->restaurant_comment
                ]);
                DB::commit();
                return redirect()->action('RestaurantsController@create');
            } catch (Exception $e) {
                DB::rollback();
                return view('error.index')->with('error', $e);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //echo $id;
        DB::beginTransaction();
        try {
            DB::table('restaurants')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('RestaurantsController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

}

<?php
/**
 *  Author: Satit Porntepanon
 *  Created Date: July 07, 2018
 *  Description:  ItemsManageController
 */

namespace App\Http\Controllers\Setting;

use DB;
use App\Hotels;
use App\Offers;
use Carbon\Carbon;
use App\Restaurants;
use App\ActionLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItemsManageController extends Controller
{

    /**
     * ItemsManageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy'
        ]]);

        $GLOBALS['controller'] = 'ItemsManageController';
        $GLOBALS['enable'] = 1;
        $GLOBALS['disable'] = 2;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $hotels = Hotels::select('hotels.id', 'hotels.hotel_name', 'actives.active')
                ->join('actives', 'hotels.active_id', '=', 'actives.id')
                ->where('active_id', $GLOBALS['disable'])->paginate(10);;

            $restaurants = Restaurants::select('restaurants.id', 'restaurants.restaurant_name', 'hotels.hotel_name', 'actives.active')
                ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                ->where('restaurants.active_id', $GLOBALS['disable'])->paginate(10);;

            $offers = Offers::select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name', 'offers.offer_name_en', 'actives.active')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->join('actives', 'offers.active_id', '=', 'actives.id')
                ->where('offers.active_id', $GLOBALS['disable'])->paginate(10);

            return view('setting.items.index', [
                'hotels' => $hotels,
                'restaurants' => $restaurants,
                'offers' => $offers
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param $hotel_id
     */
    public function enableHotel($hotel_id)
    {
        DB::beginTransaction();
        try {
            DB::table('hotels')
                ->where('id', $hotel_id)
                ->update([
                    'active_id' => $GLOBALS['enable'],
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'enableHotel', $hotel_id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\ItemsManageController@index');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param $restaurant_id
     */
    public function enableRestaurant($restaurant_id)
    {
        DB::beginTransaction();
        try {
            DB::table('restaurants')
                ->where('id', $restaurant_id)
                ->update([
                    'active_id' => $GLOBALS['enable'],
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'enableRestaurant', $restaurant_id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\ItemsManageController@index');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param $offer_id
     */
    public function enableOffer($offer_id)
    {
        DB::beginTransaction();
        try {
            DB::table('offers')
                ->where('id', $offer_id)
                ->update([
                    'active_id' => $GLOBALS['enable'],
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'enableOffer', $offer_id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\ItemsManageController@index');
        } catch (QueryException $e) {
            DB::rollback();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}

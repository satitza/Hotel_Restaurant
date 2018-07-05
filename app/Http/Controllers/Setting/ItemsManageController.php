<?php
/**
 *  Author: Satit Porntepanon
 *  Created Date: July 07, 2018
 *  Description:  ItemsManageController
 */

namespace App\Http\Controllers\Setting;

use App\Hotels;
use App\Offers;
use App\Restaurants;
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
        $GLOBALS['status'] = 2;

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
                ->where('active_id', $GLOBALS['status'])->paginate(10);;

            $restaurants = Restaurants::select('restaurants.id', 'restaurants.restaurant_name', 'hotels.hotel_name', 'actives.active')
                ->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->join('hotels', 'restaurants.hotel_id', '=', 'hotels.id')
                ->where('restaurants.active_id', $GLOBALS['status'])->paginate(10);;

            $offers = Offers::select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name', 'offers.offer_name_en', 'actives.active')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->join('actives', 'offers.active_id', '=', 'actives.id')
                ->where('offers.active_id', $GLOBALS['status'])->paginate(10);

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

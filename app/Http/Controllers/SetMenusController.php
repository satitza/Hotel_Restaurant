<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Hotels;
use App\Restaurants;
use App\TimeLunch;
use App\TimeDinner;
use App\SetMenu;

class SetMenusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $hotels = Hotels::orderBy('id', 'ASC')->where('active_id', '1')->get();
            $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();

            return view('set_menu.index', [
                'hotels' => $hotels,
                'restaurants' => $restaurants,
                'time_lunchs' => $time_lunchs,
                'time_dinners' => $time_dinners
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }


        return view('set_menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('set_menu.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->menu_time_lunch_start > $request->menu_time_lunch_end) {
            return view('error.index')->with('error', 'Time Lunch : คุณเลือกช่วงวลาอาหารวันเริ่มหลังช่วงเวลาสิ้นสุด');
        } else if ($request->menu_time_lunch_start == 1 && $request->menu_time_lunch_end != 1) {
            return view('error.index')->with('error', 'Time Lunch : คุณไม่ได้เลือกช่วงเวลาอาหารเริ่ม');
        } else if ($request->menu_time_dinner_start > $request->menu_time_dinner_end) {
            return view('error.index')->with('error', 'Time Dinner : คุณเลือกช่วงวลาเริ่มหลังช่วงเวลาสิ้นสุด');
        } else if ($request->menu_time_dinner_start == 1 && $request->menu_time_dinner_end != 1) {
            return view('error.index')->with('error', 'Time Dinner : คุณไม่ได้เลือกช่วงเวลาอาหารเริ่ม');
        } else {
            /*echo $request->hotel_id . "<br>";
            echo $request->restaurant_id . "<br>";
            echo $request->menu_name . "<br>";
            echo $request->menu_date_start . "<br>";
            echo $request->menu_date_end . "<br>";
            $date_select_json = $request->input('date_check_box');
            echo json_encode($date_select_json) . "<br>";
            echo $request->menu_time_lunch_start . "<br>";
            echo $request->menu_time_lunch_end . "<br>";
            echo $request->menu_time_dinner_start . "<br>";
            echo $request->menu_time_dinner_end . "<br>";
            echo $request->menu_price . "<br>";
            echo $request->menu_guest . "<br>";
            echo $request->set_menu_comment . "<br>";*/
            DB::beginTransaction();
            try {

                $set_menu = new SetMenu;
                $set_menu->hotel_id = $request->hotel_id;
                $set_menu->restaurant_id = $request->restaurant_id;
                $set_menu->menu_name = $request->menu_name;
                $set_menu->menu_date_start = Carbon::parse($request->menu_date_start);
                $set_menu->menu_date_end = Carbon::parse($request->menu_date_end);
                $set_menu->menu_date_select = json_encode($request->input('date_check_box'));
                $set_menu->menu_time_lunch_start = $request->menu_time_lunch_start;
                $set_menu->menu_time_lunch_end = $request->menu_time_lunch_end;
                $set_menu->menu_time_dinner_start = $request->menu_time_dinner_start;
                $set_menu->menu_time_dinner_end = $request->menu_time_dinner_end;
                $set_menu->menu_price = $request->menu_price;
                $set_menu->menu_guest = $request->menu_guest;
                $set_menu->menu_comment = $request->set_menu_comment;
                $set_menu->save();
                DB::commit();
                echo "WTF";

            } catch (Exception $e) {
                DB::rollback();
                return view('error.index')->with('error', $e);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

}

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $set_menus = DB::table('set_menus')
                ->select('set_menus.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'menu_name', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                ->orderBy('set_menus.id', 'asc')->paginate(10);
            return view('set_menu.list', [
                'set_menus' => $set_menus
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*if ($request->menu_time_lunch_start > $request->menu_time_lunch_end) {
            return view('error.index')->with('error', 'Time Lunch : คุณเลือกช่วงวลาอาหารวันเริ่มหลังช่วงเวลาสิ้นสุด');
        } else if ($request->menu_time_lunch_start == 1 && $request->menu_time_lunch_end != 1) {
            return view('error.index')->with('error', 'Time Lunch : คุณไม่ได้เลือกช่วงเวลาอาหารเริ่ม');
        } else if ($request->menu_time_dinner_start > $request->menu_time_dinner_end) {
            return view('error.index')->with('error', 'Time Dinner : คุณเลือกช่วงวลาเริ่มหลังช่วงเวลาสิ้นสุด');
        } else if ($request->menu_time_dinner_start == 1 && $request->menu_time_dinner_end != 1) {
            return view('error.index')->with('error', 'Time Dinner : คุณไม่ได้เลือกช่วงเวลาอาหารเริ่ม');
        } else {*/
        DB::beginTransaction();
        try {
            $set_menu = new SetMenu;
            $set_menu->hotel_id = $request->hotel_id;
            $set_menu->restaurant_id = $request->restaurant_id;
            $set_menu->menu_name = $request->menu_name;
            $set_menu->menu_date_start = Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_start, '/', '-'))));
            $set_menu->menu_date_end = Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_end, '/', '-'))));
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
            return redirect()->action('SetMenusController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
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
        try {
            $hotels = Hotels::orderBy('id', 'ASC')->where('active_id', '1')->get();
            $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();

            $set_menus = DB::table('set_menus')
                ->select('set_menus.id', 'set_menus.hotel_id', 'hotels.hotel_name',
                    'set_menus.restaurant_id', 'restaurants.restaurant_name',
                    'menu_name', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                ->where('set_menus.id', $id)->get();

            foreach ($set_menus as $set_menu) {
            }

            $date_start_format = date('d/m/Y', strtotime($set_menu->menu_date_start));
            $date_end_format = date('d/m/Y', strtotime($set_menu->menu_date_end));

            return view('set_menu.edit', [
                'set_menu_id' => $set_menu->id,
                'hotel_id' => $set_menu->hotel_id,
                'hotel_name' => $set_menu->hotel_name,
                'restaurant_id' => $set_menu->restaurant_id,
                'restaurant_name' => $set_menu->restaurant_name,
                'menu_name' => $set_menu->menu_name,
                'menu_date_start' => $date_start_format,
                'menu_date_end' => $date_end_format,
                'menu_date_select' => $set_menu->menu_date_select,
                'menu_time_lunch_start' => $set_menu->menu_time_lunch_start,
                'menu_time_lunch_end' => $set_menu->menu_time_lunch_end,
                'menu_time_dinner_start' => $set_menu->menu_time_dinner_start,
                'menu_time_dinner_end' => $set_menu->menu_time_dinner_end,
                'menu_price' => $set_menu->menu_price,
                'menu_guest' => $set_menu->menu_guest,
                'menu_comment' => $set_menu->menu_comment
            ])
                ->with('hotels', $hotels)
                ->with('restaurants', $restaurants)
                ->with('time_lunchs', $time_lunchs)
                ->with('time_dinners', $time_dinners);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
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
        $date_insert = NULL;
        $new_date_select = ($request->input('date_check_box'));
        
        //Check box is null
        if (!isset($new_date_select)) {
            $date_insert = $request->old_date_select;
        } else {
            $date_insert = json_encode($request->input('date_check_box'));
        }

        DB::beginTransaction();
        try {
            DB::table('set_menus')
                ->where('id', $id)
                ->update([
                    'hotel_id' => $request->hotel_id,
                    'restaurant_id' => $request->restaurant_id,
                    'menu_name' => $request->menu_name,
                    'menu_date_start' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_start, '/', '-')))),
                    'menu_date_end' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_end, '/', '-')))),
                    'menu_date_select' => $date_insert,
                    'menu_time_lunch_start' => $request->menu_time_lunch_start,
                    'menu_time_lunch_end' => $request->menu_time_lunch_end,
                    'menu_time_dinner_start' => $request->menu_time_dinner_start,
                    'menu_time_dinner_end' => $request->menu_time_dinner_end,
                    'menu_price' => $request->menu_price,
                    'menu_guest' => $request->menu_guest,
                    'menu_comment' => $request->menu_comment
                ]);
            DB::commit();
            return redirect()->action('SetMenusController@create');
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
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
            DB::table('set_menus')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('SetMenusController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

}

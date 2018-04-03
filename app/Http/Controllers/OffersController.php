<?php

namespace App\Http\Controllers;

use App\Offers;
use Illuminate\Http\Request;
use App\Language;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Hotels;
use App\Restaurants;
use App\TimeLunch;
use App\TimeDinner;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class OffersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            //'index',
            //'SearchMenu',
            //'create',
            //'store',
            //'edit',
            //'update',
            'destroy',
            'DeleteImage'
        ]]);
        $this->middleware('editor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();
            $check_rows = User::find(Auth::id());
            $restaurants = array();
            $view = null;

            //User Editor
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($restaurant_id) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($restaurant_id as $id) {
                        $arrays = explode(',', $id->restaurant_id, -1);
                        foreach ($arrays as $array) {
                            $where = ['id' => $array];
                            array_push($restaurants, Restaurants::where($where)->get());
                        }
                    }
                    $view = 'offer.editor.index';
                }
            } else {
                $view = 'offer.admin.index';
                $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
            }

            return view($view, [
                //'hotels' => $hotels,
                'restaurants' => $restaurants,
                'time_lunchs' => $time_lunchs,
                'time_dinners' => $time_dinners
            ]);


        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function SearchOffer(Request $request)
    {
        try {

            $where = null;
            $view = null;

            if ($request->search_value == 'hotel') {
                $where = ['set_menus.hotel_id' => $request->hotel_id];
            } elseif ($request->search_value == 'restaurant') {
                $where = ['set_menus.restaurant_id' => $request->restaurant_id];
            }


            $check_rows = User::find(Auth::id());
            $restaurant_items = array();
            $hotel_items = null;

            if ($check_rows->user_role == 2) {

                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    //echo $id->restaurant_id."<br>";
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurant_items, Restaurants::where($where)->get());
                    }
                }
                $view = 'offer.editor.list';
                $where = ['offers.restaurant_id' => $request->restaurant_id];
                /*$set_menus = DB::table('set_menus')->
                select('set_menus.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'menu_name_en', 'image', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment_en')
                    ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                    ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                    ->orderBy('set_menus.id', 'asc')->where('', $request->restaurant_id)->paginate(10);

                return view('set_menu.editor.list', [
                    'set_menus' => $set_menus
                ])->with('restaurants', $restaurants);*/

            } else {
                $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
                $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name')->get();
                $view = 'offer.admin.list';
            }
            $offers = DB::table('offers')->
            select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                'offer_name_en', 'image', 'offer_date_start', 'offer_date_end', 'offer_day_select',
                'offer_time_lunch_start', 'offer_time_lunch_end', 'offer_time_dinner_start',
                'offer_time_dinner_end', 'offer_price', 'offer_guest', 'offer_comment_en')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where($where)->paginate(10);

            return view($view, [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'offers' => $offers
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

            $check_rows = User::find(Auth::id());
            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name')->get();

            $restaurants = array();
            $view = null;

            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'offer_name_en', 'image', 'offer_date_start', 'offer_date_end', 'offer_day_select',
                    'offer_time_lunch_start', 'offer_time_lunch_end', 'offer_time_dinner_start',
                    'offer_time_dinner_end', 'offer_price', 'offer_guest', 'offer_comment_en')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->orderBy('offers.id', 'asc')->paginate(10);

            //Editor User
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($restaurant_id) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($restaurant_id as $id) {
                        $arrays = explode(',', $id->restaurant_id, -1);
                        foreach ($arrays as $array) {
                            $where = ['id' => $array];
                            array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());
                        }
                    }
                    return view('offer.editor.editor_info', [
                        'restaurants' => $restaurants,
                    ]);
                }
            } else {
                $view = 'offer.admin.list';
            }

            return view($view, [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'offers' => $offers
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
        $filename = null;
        if ($request->input('day_check_box') == null) {
            return view('error.index')->with('error', 'You never set date select');
        } elseif (Input::hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $request->file('image')->move($destinationPath, $filename);
        } else {
            $filename = "default.png";
        }

        DB::beginTransaction();
        try {
            $get_hotel_id = Restaurants::find($request->restaurant_id);

            $offers = new Offers;
            $offers->hotel_id = $get_hotel_id->hotel_id;
            $offers->restaurant_id = $request->restaurant_id;
            $offers->offer_name_th = $request->offer_name_th;
            $offers->offer_name_en = $request->offer_name_en;
            $offers->offer_name_cn = $request->offer_name_cn;
            $offers->image = $filename;
            $offers->offer_date_start = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-'))));
            $offers->offer_date_end = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-'))));
            //$set_menu->menu_date_select = json_encode($request->input('date_check_box'));
            $offers->offer_day_select = implode(", ", $request->input('day_check_box')) . ",";
            $offers->offer_time_lunch_start = $request->offer_time_lunch_start;
            $offers->offer_time_lunch_end = $request->offer_time_lunch_end;
            $offers->offer_time_dinner_start = $request->offer_time_dinner_start;
            $offers->offer_time_dinner_end = $request->offer_time_dinner_end;
            $offers->offer_price = $request->offer_price;
            $offers->offer_guest = $request->offer_guest;
            $offers->offer_comment_th = $request->offer_comment_th;
            $offers->offer_comment_en = $request->offer_comment_en;
            $offers->offer_comment_cn = $request->offer_comment_cn;
            $offers->save();
            DB::commit();
            return redirect()->action('OffersController@create');
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

            $restaurants = array();
            $view = null;
            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();
            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name',
                    'offers.restaurant_id', 'restaurants.restaurant_name',
                    'offer_name_th', 'offer_name_en', 'offer_name_cn', 'image', 'offer_date_start', 'offer_date_end', 'offer_day_select',
                    'offer_time_lunch_start', 'offer_time_lunch_end', 'offer_time_dinner_start',
                    'offer_time_dinner_end', 'offer_price', 'offer_guest', 'offer_comment_th', 'offer_comment_en', 'offer_comment_cn')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where('offers.id', $id)->get();

            foreach ($offers as $offer) {
            }

            $date_start_format = date('d/m/Y', strtotime($offer->offer_date_start));
            $date_end_format = date('d/m/Y', strtotime($offer->offer_date_end));

        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }

        $check_rows = User::find(Auth::id());

        //User editor
        if ($check_rows->user_role == 2) {
            $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
            foreach ($restaurant_id as $res_id) {
            }
            $arrays = explode(',', $res_id->restaurant_id, -1);
            foreach ($arrays as $array) {

                $where = ['id' => $array];
                array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());

            }
            foreach ($arrays as $array) {
                if ($offer->restaurant_id == $array) {

                }
            }
        } else {
            $view = 'offer.admin.edit';
        }
        //Administrator role
        $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
        return view($view, [
            'offer_id' => $offer->id,
            'hotel_name' => $offer->hotel_name,
            'restaurant_id' => $offer->restaurant_id,
            'restaurant_name' => $offer->restaurant_name,
            'offer_name_th' => $offer->offer_name_th,
            'offer_name_en' => $offer->offer_name_en,
            'offer_name_cn' => $offer->offer_name_cn,
            'old_image' => $offer->image,
            'offer_date_start' => $date_start_format,
            'offer_date_end' => $date_end_format,
            'offer_day_select' => $offer->offer_day_select,
            'offer_time_lunch_start' => $offer->offer_time_lunch_start,
            'offer_time_lunch_end' => $offer->offer_time_lunch_end,
            'offer_time_dinner_start' => $offer->offer_time_dinner_start,
            'offer_time_dinner_end' => $offer->offer_time_dinner_end,
            'offer_price' => $offer->offer_price,
            'offer_guest' => $offer->offer_guest,
            'offer_comment_th' => $offer->offer_comment_th,
            'offer_comment_en' => $offer->offer_comment_en,
            'offer_comment_cn' => $offer->offer_comment_cn
        ])
            ->with('restaurants', $restaurants)
            ->with('time_lunchs', $time_lunchs)
            ->with('time_dinners', $time_dinners);
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
        $day_insert = null;
        $filename = null;
        $new_day_select = ($request->input('day_check_box'));
        $get_hotel_id = Restaurants::find($request->restaurant_id);

        if (!isset($new_day_select)) {
            //Check box is null insert old date select
            $day_insert = $request->old_day_select;
        } else {
            //Check box not null insert new date select json
            $day_insert = implode(",", $request->input('day_check_box')) . ",";
        }

        try {

            if (Input::hasFile('image')) {
                //update and upload new file
                $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $request->file('image')->move($destinationPath, $filename);
                $this->DeleteImage($id);
            } else {
                //no update image
                $filename_obj = $get_old_image = Offers::find($id);
                $filename = $filename_obj->image;
            }

            DB::beginTransaction();

            DB::table('offers')
                ->where('id', $id)
                ->update([
                    'hotel_id' => $get_hotel_id->hotel_id,
                    'restaurant_id' => $request->restaurant_id,
                    'offer_name_th' => $request->offer_name_th,
                    'offer_name_en' => $request->offer_name_en,
                    'offer_name_cn' => $request->offer_name_cn,
                    'image' => $filename,
                    'offer_date_start' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-')))),
                    'offer_date_end' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-')))),
                    'offer_day_select' => $day_insert,
                    'offer_time_lunch_start' => $request->offer_time_lunch_start,
                    'offer_time_lunch_end' => $request->offer_time_lunch_end,
                    'offer_time_dinner_start' => $request->offer_time_dinner_start,
                    'offer_time_dinner_end' => $request->offer_time_dinner_end,
                    'offer_price' => $request->offer_price,
                    'offer_guest' => $request->offer_guest,
                    'offer_comment_th' => $request->offer_comment_th,
                    'offer_comment_en' => $request->offer_comment_en,
                    'offer_comment_cn' => $request->offer_comment_cn
                ]);
            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (Exception $e) {
            DB::rollback();
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
            $this->DeleteImage($id);
            DB::table('offers')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

    public
    function DeleteImage($id)
    {
        try {
            $get_old_image = Offers::find($id);
            return File::delete(public_path('images\\' . $get_old_image->image));
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Offers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Requests\OffersRequest;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Hotels;
use App\Restaurants;
use App\TimeLunch;
use App\TimeDinner;

use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;
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

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function SearchOffer(Request $request)
    {
        try {

            $where = null;
            $view = null;
            $hotel_items = null;
            $restaurant_items = array();

            if ($request->search_value == 'hotel') {
                $where = ['offers.hotel_id' => $request->hotel_id];
            } elseif ($request->search_value == 'restaurant') {
                $where = ['offers.restaurant_id' => $request->restaurant_id];
            }

            $check_rows = User::find(Auth::id());

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

            } else {
                $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
                $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name')->get();
                $view = 'offer.admin.list';
            }
            $offers = DB::table('offers')->
            select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                'offer_name_en', 'pdf', 'offer_date_start', 'offer_date_end', 'offer_comment_en')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where($where)->paginate(10);

            return view($view, [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'offers' => $offers
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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

            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'offer_name_en', 'pdf', 'offer_date_start', 'offer_date_end', 'offer_comment_en')
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
                return view('offer.admin.list', [
                    'hotel_items' => $hotel_items,
                    'restaurant_items' => $restaurant_items,
                    'offers' => $offers
                ]);
            }
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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
    public function store(OffersRequest $request)
    {
        $filename = null;

        if ($request->input('day_check_box') == null) {
            return view('error.index')->with('error', 'You never set date select');
        } elseif ($request->offer_comment_en == "<p>&nbsp;</p>") {
            return view('error.index')->with('error', 'Please insert default offer description');
        }

        DB::beginTransaction();
        try {

            if (Input::hasFile('pdf')) {
                $filename = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $destinationPath = public_path('/pdf');
                $request->file('pdf')->move($destinationPath, $filename);
            } else {
                $filename = null;
            }

            $get_hotel_id = Restaurants::find($request->restaurant_id);

            $offers = new Offers;
            $offers->hotel_id = $get_hotel_id->hotel_id;
            $offers->restaurant_id = $request->restaurant_id;
            $offers->offer_name_th = $request->offer_name_th;
            $offers->offer_name_en = $request->offer_name_en;
            $offers->offer_name_cn = $request->offer_name_cn;
            $offers->pdf = $filename;
            $offers->offer_date_start = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-'))));
            $offers->offer_date_end = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-'))));
            //$set_menu->menu_date_select = json_encode($request->input('date_check_box'));
            $offers->offer_day_select = implode(", ", $request->input('day_check_box')) . ",";
            $offers->offer_time_lunch_start = $request->offer_time_lunch_start;
            $offers->offer_time_lunch_end = $request->offer_time_lunch_end;
            $offers->offer_lunch_price = $request->offer_lunch_price;
            $offers->offer_lunch_guest = $request->offer_lunch_guest;
            $offers->offer_time_dinner_start = $request->offer_time_dinner_start;
            $offers->offer_time_dinner_end = $request->offer_time_dinner_end;
            $offers->offer_dinner_price = $request->offer_dinner_price;
            $offers->offer_dinner_guest = $request->offer_dinner_guest;
            $offers->offer_comment_th = $request->offer_comment_th;
            $offers->offer_comment_en = $request->offer_comment_en;
            $offers->offer_comment_cn = $request->offer_comment_cn;
            $offers->save();
            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
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
        try {
            $pdf = Offers::find($id);
            if (isset($pdf->pdf)) {
                return response()->file(public_path('pdf/' . $pdf->pdf));
            } else {
                return view('error.index')->with('error', 'File PDF not found');
            }
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        }
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

            $offer_name_th = null;
            $offer_name_en = null;

            $offer_comment_th = null;
            $offer_comment_cn = null;

            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();

            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name',
                    'offers.restaurant_id', 'restaurants.restaurant_name',
                    'offer_name_th', 'offer_name_en', 'offer_name_cn', 'pdf', 'offer_date_start', 'offer_date_end', 'offer_day_select',
                    'offer_time_lunch_start', 'offer_time_lunch_end', 'offer_lunch_price', 'offer_lunch_guest', 'offer_time_dinner_start',
                    'offer_time_dinner_end', 'offer_dinner_price', 'offer_dinner_guest', 'offer_comment_th', 'offer_comment_en', 'offer_comment_cn')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where('offers.id', $id)->get();

            if (Offers::where('id', '=', $id)->exists()) {
                foreach ($offers as $offer) {
                    $date_start_format = date('d/m/Y', strtotime($offer->offer_date_start));
                    $date_end_format = date('d/m/Y', strtotime($offer->offer_date_end));

                    if (!isset($offer->offer_name_th)) {
                        $offer_name_th = $offer->offer_name_en;
                    } else {
                        $offer_name_th = $offer->offer_name_th;
                    }

                    if (!isset($offer->offer_name_cn)) {
                        $offer_name_cn = $offer->offer_name_en;
                    } else {
                        $offer_name_cn = $offer->offer_name_cn;
                    }

                    if ($offer->offer_comment_th == "<p>&nbsp;</p>") {
                        $offer_comment_th = $offer->offer_comment_en;
                    } else {
                        $offer_comment_th = $offer->offer_comment_th;
                    }

                    if ($offer->offer_comment_cn == "<p>&nbsp;</p>") {
                        $offer_comment_cn = $offer->offer_comment_en;
                    } else {
                        $offer_comment_cn = $offer->offer_comment_cn;
                    }
                }

                $check_rows = User::find(Auth::id());
                //User editor
                if ($check_rows->user_role == 2) {
                    $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                    foreach ($restaurant_id as $res_id) {
                    }
                    $arrays = explode(',', $res_id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        if ($offer->restaurant_id == $array) {
                            $view = 'offer.editor.edit';
                        }
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());
                    }
                    if (!isset($view)) {
                        return view('error.index')->with('error', 'You don`t have permission');
                    }
                } else {
                    $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
                    $view = 'offer.admin.edit';
                }
                //Administrator role
                return view($view, [
                    'offer_id' => $offer->id,
                    'hotel_name' => $offer->hotel_name,
                    'restaurant_id' => $offer->restaurant_id,
                    'restaurant_name' => $offer->restaurant_name,
                    'offer_name_th' => $offer_name_th,
                    'offer_name_en' => $offer->offer_name_en,
                    'offer_name_cn' => $offer_name_cn,
                    'old_pdf' => $offer->pdf,
                    'offer_date_start' => $date_start_format,
                    'offer_date_end' => $date_end_format,
                    'offer_day_select' => $offer->offer_day_select,
                    'offer_time_lunch_start' => $offer->offer_time_lunch_start,
                    'offer_time_lunch_end' => $offer->offer_time_lunch_end,
                    'offer_lunch_price' => $offer->offer_lunch_price,
                    'offer_lunch_guest' => $offer->offer_lunch_guest,
                    'offer_time_dinner_start' => $offer->offer_time_dinner_start,
                    'offer_time_dinner_end' => $offer->offer_time_dinner_end,
                    'offer_dinner_price' => $offer->offer_dinner_price,
                    'offer_dinner_guest' => $offer->offer_dinner_guest,
                    'offer_comment_th' => $offer_comment_th,
                    'offer_comment_en' => $offer->offer_comment_en,
                    'offer_comment_cn' => $offer_comment_cn
                ])
                    ->with('restaurants', $restaurants)
                    ->with('time_lunchs', $time_lunchs)
                    ->with('time_dinners', $time_dinners);
            } else {
                return view('error.index')->with('error', 'Search not found');
            }
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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
    public function update(OffersRequest $request, $id)
    {
        $day_insert = null;
        $filename = null;

        $new_day_select = ($request->input('day_check_box'));
        $get_hotel_id = Restaurants::find($request->restaurant_id);

        if ($request->offer_comment_en == "<p>&nbsp;</p>") {
            return view('error.index')->with('error', 'Please insert default offer description');
        } elseif (!isset($new_day_select)) {
            //Check box is null insert old date select
            $day_insert = $request->old_day_select;
        } else {
            //Check box not null insert new date select json
            $day_insert = implode(",", $request->input('day_check_box')) . ",";
        }

        try {

            if (Input::hasFile('pdf')) {
                //update and upload new file
                $filename = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $destinationPath = public_path('/pdf');
                $request->file('pdf')->move($destinationPath, $filename);
                $this->DeletePDF($id);
            } else {
                //no update image
                $filename = $request->old_pdf;
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
                    'pdf' => $filename,
                    'offer_date_start' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-')))),
                    'offer_date_end' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-')))),
                    'offer_day_select' => $day_insert,
                    'offer_time_lunch_start' => $request->offer_time_lunch_start,
                    'offer_time_lunch_end' => $request->offer_time_lunch_end,
                    'offer_lunch_price' => $request->offer_lunch_price,
                    'offer_lunch_guest' => $request->offer_lunch_guest,
                    'offer_time_dinner_start' => $request->offer_time_dinner_start,
                    'offer_time_dinner_end' => $request->offer_time_dinner_end,
                    'offer_dinner_price' => $request->offer_dinner_price,
                    'offer_dinner_guest' => $request->offer_dinner_guest,
                    'offer_comment_th' => $request->offer_comment_th,
                    'offer_comment_en' => $request->offer_comment_en,
                    'offer_comment_cn' => $request->offer_comment_cn
                ]);

            if (DB::table('reports')->where('booking_offer_id', '=', $id)->exists()) {
                DB::table('reports')->where('booking_offer_id', '=', $id)
                    ->update([
                        'booking_hotel_id' => $get_hotel_id->hotel_id,
                        'booking_restaurant_id' => $request->restaurant_id
                    ]);
            }

            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
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
            $this->DeletePDF($id);
            DB::table('offers')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public
    function DeletePDF($id)
    {
        try {
            $get_old_pdf = Offers::find($id);
            return File::delete(public_path('pdf\\' . $get_old_pdf->pdf));
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }
}

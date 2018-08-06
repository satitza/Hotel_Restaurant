<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\Actives;
use App\ActionLog;
use App\Currency;
use App\Hotels;
use App\Http\Requests\OffersRequest;
use App\Images;
use App\Offers;
use App\RateSuffix;
use App\Restaurants;
use App\TimeDinner;
use App\TimeLunch;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;
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
            'DeleteAttachments',
            'DeleteAllImage'
        ]]);
        $this->middleware('editor');

        $GLOBALS['controller'] = 'OffersController';
        $GLOBALS['enable'] = 1;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $actives = $this->GetActivesItems();
            $time_lunchs = $this->GetTimeLunch();
            $time_dinners = $this->GetTimeDinner();
            $currencies = $this->GetCurrency();
            $rate_suffix = $this->GetRateSuffix();

            $check_rows = User::find(Auth::id());
            $rs = null;
            $view = null;

            //User Editor
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($restaurant_id) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    $arrays = array();
                    foreach ($restaurant_id as $id) {
                        $arrays = explode(',', $id->restaurant_id, -1);
                    }
                    $restaurants = Restaurants::select('id', 'restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();
                }
            } else {
                $restaurants = $this->GetRestaurantsItems();
            }

            return view('offer.admin.index', [
                'restaurants' => $restaurants,
                'actives' => $actives,
                'time_lunchs' => $time_lunchs,
                'time_dinners' => $time_dinners,
                'currencies' => $currencies,
                'rate_suffix' => $rate_suffix
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function SearchOffer(Request $request)
    {
        try {

            $where = null;
            $view = null;

            if ($request->search_value == 'hotel') {
                $where = ['offers.hotel_id' => $request->hotel_id, 'offers.active_id' => $GLOBALS['enable']];
            } elseif ($request->search_value == 'restaurant') {
                $where = ['offers.restaurant_id' => $request->restaurant_id, 'offers.active_id' => $GLOBALS['enable']];
            }

            $check_rows = User::find(Auth::id());

            if ($check_rows->user_role == 2) {

                $restaurants_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->first();
                $arrays = explode(',', $restaurants_id->restaurant_id, -1);
                $restaurant_items = Restaurants::select('id', 'restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();
                $view = 'offer.editor.search';
                $where = ['offers.restaurant_id' => $request->restaurant_id];

            } else {
                $hotel_items = $this->GetHotelsItems();
                $restaurant_items = $this->GetRestaurantsItems();
                $view = 'offer.admin.search';
            }
            $offers = DB::table('offers')->
            select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                'offer_name_en', 'attachments', 'offer_date_start', 'offer_date_end', 'offer_comment_en')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where($where)->paginate(10);

            return view($view, [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
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
        try {

            $check_rows = User::find(Auth::id());
            $hotel_items = $this->GetHotelsItems();
            $view = null;

            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'offer_name_en', 'offer_type','attachments', 'offer_date_start', 'offer_date_end', 'offer_comment_en')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->where('offers.active_id', $GLOBALS['enable'])->orderBy('offers.id', 'asc')->paginate(10);

            //Editor User
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($restaurant_id) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($restaurant_id as $id) {
                        $arrays = explode(',', $id->restaurant_id, -1);
                    }
                    $restaurant_items = Restaurants::select('id', 'restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();
                    $view = 'offer.editor.list';
                }
            } else {
                $restaurant_items = $this->GetRestaurantsItems();
                $view = 'offer.admin.list';
            }
            return view($view, [
                'hotel_items' => $hotel_items,
                'restaurant_items' => $restaurant_items,
                'offers' => $offers
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

    public function store(OffersRequest $request)
    {
        $filename = null;

        $day_select = null;

        $time_lunch_start = null;
        $time_lunch_end = null;

        $time_dinner_start = null;
        $time_dinner_end = null;

        $lunch_price = 0;
        $lunch_guest = 0;

        $dinner_price = 0;
        $dinner_guest = 0;

        if ($request->offer_type == 'voucher') {
            $day_select = null;

            $time_lunch_start = null;
            $time_lunch_end = null;

            $time_dinner_start = null;
            $time_dinner_end = null;

            if($request->offer_lunch_price == null){
                return view('error.index')->with('error', 'Lunch price is cannot be null in set offer type voucher');
            }else if ($request->offer_lunch_guest == null){
                return view('error.index')->with('error', 'Lunch guest is cannot be null in set offer type voucher');
            }

            if($request->offer_dinner_price == null){
                return view('error.index')->with('error', 'Dinner price is cannot be null in set offer type voucher');
            }else if ($request->offer_dinner_guest == null){
                return view('error.index')->with('error', 'Dinner guest is cannot be null in set offer type voucher');
            }

        } else if ($request->input('day_check_box') == null) {
            return view('error.index')->with('error', 'You never set date select');
        } else {
            $day_select = implode(", ", $request->input('day_check_box')) . ",";

            $time_lunch_start = $request->offer_time_lunch_start;
            $time_lunch_end = $request->offer_time_lunch_end;

            $time_dinner_start = $request->offer_time_dinner_start;
            $time_dinner_end = $request->offer_time_dinner_end;

        }


        if($request->offer_type == 'offer'){
            if ($request->offer_time_lunch_start != 'closed' || $request->offer_time_lunch_end != 'closed') {
                $lunch_price = $request->offer_lunch_price;
                $lunch_guest = $request->offer_lunch_guest;
            }

            if ($request->offer_time_dinner_start != 'closed' || $request->offer_time_dinner_end != 'closed') {
                $dinner_price = $request->offer_dinner_price;
                $dinner_guest = $request->offer_dinner_guest;
            }
        }else{

            $lunch_price = $request->offer_lunch_price;
            $lunch_guest = $request->offer_lunch_guest;

            $dinner_price = $request->offer_dinner_price;
            $dinner_guest = $request->offer_dinner_guest;

        }


        if ($request->offer_short_en == "<p>&nbsp;</p>") {
            return view('error.index')->with('error', 'Please insert default offer short description');
        } else if ($request->offer_comment_en == "<p>&nbsp;</p>") {
            return view('error.index')->with('error', 'Please insert default offer long description');
        }

        DB::beginTransaction();
        try {

            if (Input::hasFile('attachments')) {
                $filename = time() . '.' . $request->file('attachments')->getClientOriginalExtension();
                $destinationPath = public_path('/attachments');
                $request->file('attachments')->move($destinationPath, $filename);


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
            $offers->attachments = $filename;
            $offers->offer_date_start = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-'))));
            $offers->offer_date_end = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-'))));

            $offers->offer_day_select = $day_select;

            $offers->offer_time_lunch_start = $time_lunch_start;
            $offers->offer_time_lunch_end = $time_lunch_end;
            $offers->offer_lunch_price = $lunch_price;
            $offers->offer_lunch_guest = $lunch_guest;

            $offers->offer_time_dinner_start = $time_dinner_start;
            $offers->offer_time_dinner_end = $time_dinner_end;
            $offers->offer_dinner_price = $dinner_price;
            $offers->offer_dinner_guest = $dinner_guest;

            $offers->currency_id = $request->offer_currency;
            $offers->rate_suffix_id = $request->offer_rate_suffix;
            $offers->offer_short_th = $request->offer_short_th;
            $offers->offer_short_en = $request->offer_short_en;
            $offers->offer_short_cn = $request->offer_short_cn;
            $offers->offer_comment_th = $request->offer_comment_th;
            $offers->offer_comment_en = $request->offer_comment_en;
            $offers->offer_comment_cn = $request->offer_comment_cn;

            $offers->offer_type = $request->offer_type;

            $offers->active_id = $request->active_id;
            $offers->save();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (QueryException $e) {
            DB::rollback();
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
        try {
            $attachments = Offers::find($id);
            if (isset($attachments->attachments)) {
                return response()->file(public_path('attachments/' . $attachments->attachments));
            } else {
                return view('error.index')->with('error', 'File Attachments not found');
            }
        } catch (FileException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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

            $restaurant_items = null;
            $view = null;

            $offer_name_th = null;
            $offer_name_en = null;

            $offer_short_th = null;
            $offer_short_cn = null;

            $offer_comment_th = null;
            $offer_comment_cn = null;

            $time_lunchs = $this->GetTimeLunch();
            $time_dinners = $this->GetTimeDinner();
            $actives = $this->GetActivesItems();
            $currencies = $this->GetCurrency();
            $rate_suffix = $this->GetRateSuffix();

            $offers = DB::table('offers')
                ->select('offers.id', 'hotels.hotel_name',
                    'offers.restaurant_id', 'restaurants.restaurant_name', 'offer_name_th', 'offer_name_en', 'offer_name_cn',
                    'attachments', 'offer_date_start', 'offer_date_end', 'offer_day_select', 'offer_time_lunch_start',
                    'offer_time_lunch_end', 'offer_lunch_price', 'offer_lunch_guest', 'offer_time_dinner_start',
                    'offer_time_dinner_end', 'offer_dinner_price', 'offer_dinner_guest', 'offers.currency_id', 'currencies.currency',
                    'offers.rate_suffix_id', 'rate_suffixes.rate_suffix', 'offer_short_th', 'offer_short_en', 'offer_short_cn',
                    'offer_comment_th', 'offer_comment_en', 'offer_comment_cn', 'offers.offer_type', 'actives.active', 'offers.active_id')
                ->join('actives', 'offers.active_id', '=', 'actives.id')
                ->join('hotels', 'offers.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'offers.restaurant_id', '=', 'restaurants.id')
                ->join('currencies', 'offers.currency_id', '=', 'currencies.id')
                ->join('rate_suffixes', 'offers.rate_suffix_id', '=', 'rate_suffixes.id')
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

                    if ($offer->offer_short_th == "<p>&nbsp;</p>") {
                        $offer_short_th = $offer->offer_short_en;
                    } else {
                        $offer_short_th = $offer->offer_short_th;
                    }

                    if ($offer->offer_short_cn == "<p>&nbsp;</p>") {
                        $offer_short_cn = $offer->offer_short_en;
                    } else {
                        $offer_short_cn = $offer->offer_short_cn;
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
                    $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->first();
                    $arrays = explode(',', $restaurant_id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        if ($offer->restaurant_id == $array) {
                            $view = 'offer.editor.edit';
                        }
                    }
                    $restaurant_items = Restaurants::select('id', 'restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();

                    if (!isset($view)) {
                        return view('error.index')->with('error', 'You don`t have permission');
                    }
                } else {
                    $restaurant_items = $this->GetRestaurantsItems();
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
                    'offer_type' => $offer->offer_type,
                    'offer_active' => $offer->active,
                    'offer_active_id' => $offer->active_id,
                    'old_attachments' => $offer->attachments,
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
                    'currency_id' => $offer->currency_id,
                    'currency' => $offer->currency,
                    'rate_suffix_id' => $offer->rate_suffix_id,
                    'rate_suffix' => $offer->rate_suffix,
                    'offer_short_th' => $offer_short_th,
                    'offer_short_en' => $offer->offer_short_en,
                    'offer_short_cn' => $offer_short_cn,
                    'offer_comment_th' => $offer_comment_th,
                    'offer_comment_en' => $offer->offer_comment_en,
                    'offer_comment_cn' => $offer_comment_cn
                ])
                    ->with('restaurants', $restaurant_items)
                    ->with('actives', $actives)
                    ->with('time_lunchs', $time_lunchs)
                    ->with('time_dinners', $time_dinners)
                    ->with('currencies', $currencies)
                    ->with('rate_suffixes', $rate_suffix);
            } else {
                return view('error.index')->with('error', 'Search not found');
            }
        } catch (QueryException $e) {
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
    public function update(OffersRequest $request, $id)
    {

        $day_insert = null;
        $filename = null;

        $time_lunch_start = null;
        $time_lunch_end = null;
        $lunch_price = 0;
        $lunch_guest = 0;

        $time_dinner_start = null;
        $time_dinner_end = null;
        $dinner_price = 0;
        $dinner_guest = 0;

        $new_day_select = ($request->input('day_check_box'));
        $get_hotel_id = Restaurants::find($request->restaurant_id);


        if($request->offer_type == 'voucher'){
            $day_insert = null;

            $time_lunch_start = null;
            $time_lunch_end = null;
            $lunch_price = $request->offer_lunch_price;
            $lunch_guest = $request->offer_lunch_guest;

            $time_dinner_start = null;
            $time_dinner_end = null;
            $dinner_price = $request->offer_dinner_price;
            $dinner_guest = $request->offer_dinner_guest;

        }else if ($request->offer_type == 'offer'){
            if (!isset($new_day_select)) {
                //Check box is null insert old date select
                if($request->old_day_select == null){
                    return view('error.index')->with('error', 'Day select cannot be not empty in offer type offer');
                }else{
                    $day_insert = $request->old_day_select;
                }
            } else {
                //Check box not null insert new date select json
                $day_insert = implode(",", $request->input('day_check_box')) . ",";
            }

            if($request->offer_time_lunch_start == null || $request->offer_time_lunch_end == null){
                return view('error.index')->with('error', 'Time lunch cannot be empty in offer type offer');
            }else if ($request->offer_time_dinner_start == null || $request->offer_time_dinner_end == null){
                return view('error.index')->with('error', 'Time Dinner cannot be empty in offer type offer');
            }

            if ($request->offer_time_lunch_start != 'closed' || $request->offer_time_lunch_end != 'closed') {
                $lunch_price = $request->offer_lunch_price;
                $lunch_guest = $request->offer_lunch_guest;
            }

            if ($request->offer_time_dinner_start != 'closed' || $request->offer_time_dinner_end != 'closed') {
                $dinner_price = $request->offer_dinner_price;
                $dinner_guest = $request->offer_dinner_guest;
            }

            if ($request->offer_comment_en == "<p>&nbsp;</p>") {
                return view('error.index')->with('error', 'Please insert default offer description');
            }

            $time_lunch_start = $request->offer_time_lunch_start;
            $time_lunch_end = $request->offer_time_lunch_end;

            $time_dinner_start = $request->offer_time_dinner_start;
            $time_dinner_end = $request->offer_time_dinner_end;
        }

        try {

            if (Input::hasFile('attachments')) {
                //update and upload new file
                $filename = time() . '.' . $request->file('attachments')->getClientOriginalExtension();
                $destinationPath = public_path('/attachments');
                $request->file('attachments')->move($destinationPath, $filename);
                $this->DeleteAttachments($id);
            } else {
                //no update image
                if ($request->old_attachments == '') {
                    $filename = $request->old_attachments;
                    $this->DeleteAttachments($id);
                } else {
                    $filename = $request->old_attachments;
                }
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
                    'attachments' => $filename,
                    'offer_date_start' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_start, '/', '-')))),
                    'offer_date_end' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_end, '/', '-')))),
                    'offer_day_select' => $day_insert,
                    'offer_time_lunch_start' => $time_lunch_start,
                    'offer_time_lunch_end' => $time_lunch_end,
                    'offer_lunch_price' => $lunch_price,
                    'offer_lunch_guest' => $lunch_guest,
                    'offer_time_dinner_start' => $time_dinner_start,
                    'offer_time_dinner_end' => $time_dinner_end,
                    'offer_dinner_price' => $dinner_price,
                    'offer_dinner_guest' => $dinner_guest,
                    'currency_id' => $request->offer_currency,
                    'rate_suffix_id' => $request->offer_rate_suffix,
                    'offer_short_th' => $request->offer_short_th,
                    'offer_short_en' => $request->offer_short_en,
                    'offer_short_cn' => $request->offer_short_cn,
                    'offer_comment_th' => $request->offer_comment_th,
                    'offer_comment_en' => $request->offer_comment_en,
                    'offer_comment_cn' => $request->offer_comment_cn,
                    'offer_type' => $request->offer_type,
                    'active_id' => $request->active_id,
                    'updated_at' => Carbon::now()
                ]);

            if (DB::table('reports')->where('booking_offer_id', '=', $id)->exists()) {
                DB::table('reports')->where('booking_offer_id', '=', $id)
                    ->update([
                        'booking_hotel_id' => $get_hotel_id->hotel_id,
                        'booking_restaurant_id' => $request->restaurant_id,
                        'currency_id' => $request->offer_currency,
                        'rate_suffix_id' => $request->offer_rate_suffix,
                    ]);
            }

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

            DB::commit();
            return redirect()->action('OffersController@create');
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

            $this->DeleteAttachments($id);
            $this->DeleteAllImage($id);
            DB::table('offers')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);

            DB::commit();
            return redirect()->action('OffersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public
    function DeleteAllImage($offer_id)
    {
        try {

            if (Images::where('offer_id', '=', $offer_id)->exists()) {
                $old_images = Images::where('offer_id', '=', $offer_id)->first();
                $old_images_array = explode(',', $old_images->image);

                foreach ($old_images_array as $item) {
                    File::delete(public_path('images\\' . $item));
                }
            }
        } catch (FileException $e) {
            throw new FileException("File delete exception");
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public
    function DeleteAttachments($id)
    {
        try {
            $get_old_attachments = Offers::find($id);
            return File::delete(public_path('attachments\\' . $get_old_attachments->attachments));
        } catch (FileException $e) {
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
        return Restaurants::select('id', 'restaurant_name')->where('restaurants.active_id', $GLOBALS['enable'])->orderBy('restaurant_name', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetHotelsItems()
    {
        return Hotels::select('id', 'hotel_name')->where('hotels.active_id', $GLOBALS['enable'])->orderBy('hotel_name', 'ASC')->get();
    }


    /**
     * @return mixed
     */
    public function GetActivesItems()
    {
        return Actives::orderBy('id', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetTimeLunch()
    {
        return TimeLunch::orderBy('id', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetTimeDinner()
    {
        return TimeDinner::orderBy('id', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetCurrency()
    {
        return Currency::orderBy('id', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetRateSuffix()
    {
        return RateSuffix::orderBy('id', 'ASC')->get();
    }


}

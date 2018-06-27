<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\Report;
use App\Voucher;
use DB;
use App\User;
use App\UserReport;
use App\Offers;
use App\Restaurants;
use App\Hotels;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('admin', ['only' => [
            'ListBookingPending',
            'DeletePending',
            'DeleteAllPending',
            //'index',
            //'SearchReports',
            //'create',
            //'store',
            //'show',
            //'edit',
            //'update',
            'destroy',
            //'GetRestaurants',
            //'GetOffers'
        ]]);
        $this->middleware('report');

        $GLOBALS['controller'] = 'ReportsController';

    }

    public function ListBookingPending()
    {
        try {

            $reports = DB::table('reports')
                ->select('reports.id', 'booking_id', 'booking_offer_id', 'offer_name_en', 'booking_date', 'booking_guest',
                    'booking_contact_firstname', 'booking_contact_lastname', 'booking_contact_email', 'booking_contact_phone', 'booking_voucher')
                ->join('offers', 'reports.booking_offer_id', '=', 'offers.id')
                ->orderBy('reports.id', 'desc')->where('booking_status', 1)->paginate(10);

            return view('report.admin.list_pending', [
                'reports' => $reports
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function DeletePending(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('reports')->where('booking_status', 1)
                ->whereDate('booking_date', '<', Carbon::parse(date('Y-m-d', strtotime(strtr($request->delete_before_date, '/', '-')))))
                ->delete();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'DeletePending', Carbon::parse(date('Y-m-d', strtotime(strtr($request->delete_before_date, '/', '-')))));

            DB::commit();
            return redirect()->action('ReportsController@ListBookingPending');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function DeleteAllPending()
    {
        DB::beginTransaction();
        try {

            DB::table('reports')->where('booking_status', 1)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'DeleteAllPending', '');

            DB::commit();
            return redirect()->action('ReportsController@ListBookingPending');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $items = null;
            $view = null;
            $where = null;

            $count_book = null;
            $count_guest = null;
            $count_price = null;

            $check_rows = User::find(Auth::id());

            if ($check_rows->user_role == 3) {
                $get_hotel_id = UserReport::select('hotel_id')->where('user_id', $check_rows->id)->get();
                if (count($get_hotel_id) == 0) {
                    return view('error.index')->with('error', 'You never match hotel with this user');
                } else {
                    foreach ($get_hotel_id as $get_id) {
                        $items = Restaurants::select('id', 'restaurant_name')->where('hotel_id', $get_id->hotel_id)->orderBy('id', 'ASC')->get();
                        $where = ['booking_status' => 2, 'booking_hotel_id' => $get_id->hotel_id];

                        $count_book = Report::where('booking_hotel_id', '=', $get_id->hotel_id)->count();
                        $count_guest = Report::select('booking_guest')->where('booking_hotel_id', '=', $get_id->hotel_id)->sum('booking_guest');
                        $count_price = Report::select('booking_guest')->where('booking_hotel_id', '=', $get_id->hotel_id)->sum('booking_price');
                    }

                    $view = 'report.user.index';
                }
            } else {

                $items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
                $where = ['booking_status' => 2];
                $view = 'report.admin.index';

                $count_book = Report::count();
                $count_guest = Report::select('booking_guest')->sum('booking_guest');
                $count_price = Report::select('booking_guest')->sum('booking_price');

            }

            $reports = DB::table('reports')
                ->select('reports.id', 'booking_id', 'offers.offer_name_en', 'hotel_name', 'restaurant_name', 'booking_date',
                    'booking_guest', 'booking_contact_firstname', 'booking_contact_lastname', 'booking_price',
                    'currency', 'rate_suffix', 'booking_voucher')
                ->where($where)
                ->join('hotels', 'hotels.id', '=', 'reports.booking_hotel_id')
                ->join('restaurants', 'restaurants.id', '=', 'reports.booking_restaurant_id')
                ->join('offers', 'offers.id', '=', 'reports.booking_offer_id')
                ->join('currencies', 'offers.currency_id', '=', 'currencies.id')
                ->join('rate_suffixes', 'offers.rate_suffix_id', '=', 'rate_suffixes.id')
                ->orderBy('reports.booking_date', 'asc')->paginate(10);

            return view($view, [
                'items' => $items,
                'count_book' => $count_book,
                'count_guest' => $count_guest,
                'count_price' => $count_price,
                'reports' => $reports
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function SearchReports(Request $request)
    {

        $hotel_id = null;
        $restaurant_id = null;
        $offer_id = null;
        $offer_date_from = null;
        $offer_date_to = null;

        if (!isset($request->hotel_id)) {
            $hotel_id = '';
        } else {
            $hotel_id = $request->hotel_id;
        }

        if (!isset($request->restaurant_id)) {
            $restaurant_id = '';
        } else {
            $restaurant_id = $request->restaurant_id;
        }

        if (!isset($request->offer_id)) {
            $offer_id = '';
        } else {
            $offer_id = $request->offer_id;
        }

        /*--------------------------------------------------------------------------------------------------------------------------------*/

        $view = null;
        $items = null;

        $check_rows = User::find(Auth::id());

        if ($check_rows->user_role == 3) {
            $get_hotel_id = UserReport::select('hotel_id')->where('user_id', $check_rows->id)->first();
            $items = Restaurants::select('id', 'restaurant_name')->where('hotel_id', $get_hotel_id->hotel_id)->orderBy('id', 'ASC')->get();
            $hotel_id = $get_hotel_id->hotel_id;
            $view = 'report.user.list';
        } else {
            $items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $view = 'report.admin.list';
        }

        try {

            $reports = null;

            if($request->offer_date_from != '' && $request->offer_date_to != ''){
                $reports = DB::table('reports')
                    ->select('reports.id', 'booking_id', 'offers.offer_name_en', 'hotel_name', 'restaurant_name', 'booking_date',
                        'booking_guest', 'booking_contact_firstname', 'booking_contact_lastname', 'booking_price',
                        'currency', 'rate_suffix', 'booking_voucher')
                    ->where('booking_hotel_id', 'like', '%' . $hotel_id . '%')
                    ->where('booking_restaurant_id', 'like', '%' . $restaurant_id . '%')
                    ->where('booking_offer_id', 'like', '%' . $offer_id . '%')
                    ->whereBetween('booking_date', [
                        Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_from, '/', '-'))))->toDateString(),
                        Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date_to, '/', '-'))))->toDateString()
                    ])
                    ->where('booking_status', '=', 2)
                    ->join('hotels', 'hotels.id', '=', 'reports.booking_hotel_id')
                    ->join('restaurants', 'restaurants.id', '=', 'reports.booking_restaurant_id')
                    ->join('offers', 'offers.id', '=', 'reports.booking_offer_id')
                    ->join('currencies', 'offers.currency_id', '=', 'currencies.id')
                    ->join('rate_suffixes', 'offers.rate_suffix_id', '=', 'rate_suffixes.id')
                    ->orderBy('reports.booking_date', 'asc')->get();
            }
            else{

                $reports = DB::table('reports')
                    ->select('reports.id', 'booking_id', 'offers.offer_name_en', 'hotel_name', 'restaurant_name', 'booking_date',
                        'booking_guest', 'booking_contact_firstname', 'booking_contact_lastname', 'booking_price',
                        'currency', 'rate_suffix', 'booking_voucher')
                    ->where('booking_hotel_id', 'like', '%' . $hotel_id . '%')
                    ->where('booking_restaurant_id', 'like', '%' . $restaurant_id . '%')
                    ->where('booking_offer_id', 'like', '%' . $offer_id . '%')
                    ->where('booking_status', '=', 2)
                    ->join('hotels', 'hotels.id', '=', 'reports.booking_hotel_id')
                    ->join('restaurants', 'restaurants.id', '=', 'reports.booking_restaurant_id')
                    ->join('offers', 'offers.id', '=', 'reports.booking_offer_id')
                    ->join('currencies', 'offers.currency_id', '=', 'currencies.id')
                    ->join('rate_suffixes', 'offers.rate_suffix_id', '=', 'rate_suffixes.id')
                    ->orderBy('reports.booking_date', 'asc')->get();
            }

            $count_book = 0;
            $count_guest = 0;
            $count_price = 0;

            foreach ($reports as $report){
                $count_book++;
                $count_guest = $count_guest + $report->booking_guest;
                $count_price = $count_price + $report->booking_price;
            }


            return view($view, [
                'items' => $items,
                'count_book' => $count_book,
                'count_guest' => $count_guest,
                'count_price' => $count_price,
                'reports' => $reports

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
        //echo $id;
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
        DB::beginTransaction();
        try {

            DB::table('reports')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);
            DB::commit();
            return redirect()->action('ReportsController@ListBookingPending');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function GetRestaurants()
    {
        try {
            $id = $_GET['id'];
            $restaurants = Restaurants::select('id', 'restaurant_name')->where('hotel_id', $id)->orderBy('restaurant_name', 'ASC')->get();
            return Response()->json($restaurants);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function GetOffers()
    {
        try {
            $restaurant_id = $_GET['id'];
            $offers = Offers::select('id', 'offer_name_en')->where('restaurant_id', $restaurant_id)->orderBy('offer_name_en', 'ASC')->get();
            return Response()->json($offers);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function ViewVoucher($booking_id)
    {
        if (Voucher::where('voucher_booking_id', $booking_id)->exists()) {
            try {
                $vouchers = Voucher::where('voucher_booking_id', $booking_id)->first();
                return view('report.voucher', [
                    'booking_id' => $vouchers->voucher_booking_id,
                    'voucher_title' => $vouchers->voucher_contact_title,
                    'voucher_fname' => $vouchers->voucher_contact_firstname,
                    'voucher_lname' => $vouchers->voucher_contact_lastname,
                    'voucher_email' => $vouchers->voucher_contact_email,
                    'voucher_phone' => $vouchers->voucher_contact_phone,
                    'voucher_request' => $vouchers->voucher_contact_request
                ]);
            } catch (QueryException $e) {
                return view('error.index')->with('error', $e->getMessage());
            } catch (Exception $e) {
                return view('error.index')->with('error', $e->getMessage());
            }
        } else {
            return view('error.index')->with('error', 'Voucher not found');
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
}

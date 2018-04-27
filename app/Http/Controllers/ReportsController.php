<?php

namespace App\Http\Controllers;

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
    }

    public function ListBookingPending()
    {
        try {

            $reports = DB::table('reports')
                ->select('reports.id', 'booking_id', 'booking_offer_id', 'offer_name_en', 'booking_date', 'booking_guest',
                    'booking_contact_firstname', 'booking_contact_lastname', 'booking_contact_email', 'booking_contact_phone')
                ->join('offers', 'reports.booking_offer_id', '=', 'offers.id')
                ->orderBy('reports.id', 'asc')->where('booking_status', 1)->paginate(10);

            return view('report.admin.list_pending', [
                'reports' => $reports
            ]);

        } catch (QueryException $e) {
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

            $check_rows = User::find(Auth::id());

            if ($check_rows->user_role == 3) {
                $get_hotel_id = UserReport::select('hotel_id')->where('user_id', $check_rows->id)->get();
                if (count($get_hotel_id) == 0) {
                    return view('error.index')->with('error', 'You never match hotel with this user');
                } else {
                    foreach ($get_hotel_id as $get_id) {
                        $items = Restaurants::select('id', 'restaurant_name')->where('hotel_id', $get_id->hotel_id)->orderBy('id', 'ASC')->get();
                    }
                    $view = 'report.user.index';
                }
            } else {
                $items = Hotels::select('id', 'hotel_name')->orderBy('id', 'ASC')->get();
                $view = 'report.admin.index';
            }

            return view($view, [
                'items' => $items
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
        $offer_date = null;

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

        if (!isset($request->offer_date)) {
            $offer_date = '';
        } else {
            $offer_date = Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date, '/', '-'))))->toDateString();
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

            $reports = DB::table('reports')
                ->select('reports.id', 'booking_id', 'booking_guest', 'booking_contact_firstname',
                    'booking_contact_lastname', 'booking_price')
                ->where('booking_hotel_id', 'like', '%' . $hotel_id . '%')
                ->where('booking_restaurant_id', 'like', '%' . $restaurant_id . '%')
                ->where('booking_offer_id', 'like', '%' . $offer_id . '%')
                ->where('booking_date', 'like', '%' . $offer_date . '%')
                ->where('booking_status', '=', 2)
                ->orderBy('reports.id', 'asc')->paginate(10);

            return view($view, [
                'reports' => $reports,
                'items' => $items
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
            DB::commit();
            return redirect()->action('ReportsController@ListBookingPending');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function CheckBill($id, $booking_id)
    {

    }

    public function GetRestaurants()
    {
        try {
            $id = $_GET['id'];
            $restaurants = Restaurants::select('id', 'restaurant_name')->where('hotel_id', $id)->orderBy('id', 'ASC')->get();
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
            $offers = Offers::select('id', 'offer_name_en')->where('restaurant_id', $restaurant_id)->orderBy('id', 'ASC')->get();
            return Response()->json($offers);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

}

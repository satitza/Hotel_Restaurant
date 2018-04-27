<?php

namespace App\Http\Controllers;

use DB;
use App\Offers;
use App\Restaurants;
use App\Hotels;
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
            //'create',
            //'store',
            //'show',
            //'edit',
            //'update',
            //'destroy',
            'GetRestaurants',
            'GetOffers'
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

            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            return view('report.admin.index', [
                'hotel_items' => $hotel_items
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function SearchReports(Request $request)
    {
        echo $request->hotel_id . "<br>";
        echo $request->restaurant_id . "<br>";
        echo $request->offer_id . "<br>";
        echo $request->offer_date . "<br>";
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
            $id = $_GET['id'];
            $offers = Offers::select('id', 'offer_name_en')->where('restaurant_id', $id)->orderBy('id', 'ASC')->get();
            return Response()->json($offers);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

}

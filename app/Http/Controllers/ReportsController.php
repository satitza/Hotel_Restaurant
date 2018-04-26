<?php

namespace App\Http\Controllers;

use DB;
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
            //'destroy'
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
        echo "index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('report.admin.list');
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

    public function CheckBill($id, $booking_id)
    {

        echo $id . "<br>";
        echo $booking_id . "<br>";

        /*if (DB::table('reports')->where('booking_id', $book_id)->exists()) {

            $booking = DB::table('reports')->where('booking_id', $book_id)->first();

            echo "booking id : " . $booking->booking_id;


        } else {
            throw  new Exception("Booking id not found");
        }


        try {


        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }*/
    }
}

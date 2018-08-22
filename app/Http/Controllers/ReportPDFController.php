<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\Report;
use App\User;
use Carbon\Carbon;
use App\ActionLog;
use App\UserReport;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ReportPDFController extends Controller
{
    /**
     * ReportPDFController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('report');

        $GLOBALS['controller'] = 'ReportPDFController';

        $GLOBALS['pending'] = 1;
        $GLOBALS['complete'] = 2;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadAllPdf()
    {
        try {

            $count_book = null;
            $count_guest = null;
            $count_price = null;

            $where = null;

            if (Auth::user()->user_role == 3) {

                $get_hotel_id = UserReport::select('hotel_id')->where('user_id', Auth::id())->first();
                $where = ['reports.booking_hotel_id' => $get_hotel_id->hotel_id, 'reports.booking_status' => $GLOBALS['complete']];

                $count_book = Report::where($where)->count();
                $count_guest = Report::select('booking_guest')->where($where)->sum('booking_guest');
                $count_price = Report::select('booking_guest')->where($where)->sum('booking_price');

            } else {

                $where = ['booking_status' => $GLOBALS['complete']];

                $count_book = Report::where($where)->count();
                $count_guest = Report::select('booking_guest')->where($where)->sum('booking_guest');
                $count_price = Report::select('booking_guest')->where($where)->sum('booking_price');
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
                ->orderBy('reports.booking_date', 'asc')->get();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'loadAllPdf', '');

            $pdf = PDF::loadView('pdf.load_pdf', [
                'date_now' => Carbon::now()->format('d-m-Y'),
                'reports' => $reports,
                'count_book' => $count_book,
                'count_guest' => $count_guest,
                'count_price' => $count_price
            ]);
            return $pdf->stream('load_pdf.pdf');


        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function CustomPdf(Request $request)
    {

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
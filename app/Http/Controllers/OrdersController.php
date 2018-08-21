<?php

namespace App\Http\Controllers;

use DB;
use App\ActionLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $GLOBALS['controller'] = 'OrdersController';

        $GLOBALS['pending'] = 1;
        $GLOBALS['complete'] = 2;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    public function searchOrder(Request $request)
    {
        try {

            $where = ['reports.booking_id' => $request->order_id];
            $orders = DB::table('reports')
                ->select('reports.id', 'booking_id', 'offers.offer_name_en', 'hotel_name', 'restaurant_name', 'booking_date',
                    'booking_guest', 'booking_contact_firstname', 'booking_contact_lastname', 'booking_price',
                    'currency', 'rate_suffix', 'booking_voucher', 'booking_status', 'usage_status')
                ->where($where)
                ->join('hotels', 'hotels.id', '=', 'reports.booking_hotel_id')
                ->join('restaurants', 'restaurants.id', '=', 'reports.booking_restaurant_id')
                ->join('offers', 'offers.id', '=', 'reports.booking_offer_id')
                ->join('currencies', 'offers.currency_id', '=', 'currencies.id')
                ->join('rate_suffixes', 'offers.rate_suffix_id', '=', 'rate_suffixes.id')
                ->first();

            if ($orders == null) {
                return view('error.index')->with('error', 'Order ID not found');
            } else if ($orders->booking_status == $GLOBALS['pending']) {
                return view('error.index')->with('error', 'Order ID is not paid');
            } else {

                return view('order.edit', [
                    'id' => $orders->id,
                    'booking_id' => $orders->booking_id,
                    'offer_name_en' => $orders->offer_name_en,
                    'hotel_name' => $orders->hotel_name,
                    'restaurant_name' => $orders->restaurant_name,
                    'booking_date' => $orders->booking_date,
                    'first_name' => $orders->booking_contact_firstname,
                    'last_name' => $orders->booking_contact_lastname,
                    'booking_guest' => $orders->booking_guest,
                    'booking_price' => $orders->booking_price,
                    'currency' => $orders->currency,
                    'rate_suffix' => $orders->rate_suffix,
                    'gift_voucher' => $orders->booking_voucher,
                    'usage_status' => $orders->usage_status
                ]);

            }

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function updateUsage($order_id)
    {
        DB::beginTransaction();
        try {
            DB::table('reports')
                ->where('booking_id', $order_id)
                ->update([
                    'usage_status' => 'used',
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'updateUsage', $order_id);

            DB::commit();
            return redirect()->action('OrdersController@index');
        } catch (QueryException $e) {
            DB::rollback();
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
        //
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

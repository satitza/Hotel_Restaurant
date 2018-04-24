<?php

namespace App\Http\Controllers;

use DB;
use App\BookCheckBalance;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Mockery\Exception;

class BalancesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*try {
            return view('balance.index');
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $offer_items = DB::table('offers')->select('id', 'offer_name_en')->get();

            $balances = $balances = DB::table('book_check_balances')
                ->select('book_check_balances.id', 'book_offer_id', 'offers.offer_name_en', 'book_time_type',
                    'book_offer_date', 'book_offer_guest', 'book_offer_balance', 'active')
                ->join('offers', 'book_check_balances.book_offer_id', '=', 'offers.id')
                ->join('actives', 'book_check_balances.active_id', '=', 'actives.id')
                ->orderBy('book_check_balances.id', 'asc')->paginate(10);

            return view('balance.list', [
                'balances' => $balances,
                'offer_items' => $offer_items
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function SearchBalance(Request $request)
    {
        if (!isset($request->offer_date)) {
            return view('error.index')->with('error', 'You never select offer date for search');
        } else {
            try {

                //echo Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date, '/', '-'))));

                $where = ['book_offer_id' => $request->offer_id, 'book_time_type' => $request->time_type];
                $offer_items = DB::table('offers')->select('id', 'offer_name_en')->get();
                $balances = $balances = DB::table('book_check_balances')
                    ->select('book_check_balances.id', 'book_offer_id', 'offers.offer_name_en', 'book_time_type',
                        'book_offer_date', 'book_offer_guest', 'book_offer_balance', 'active')
                    ->join('offers', 'book_check_balances.book_offer_id', '=', 'offers.id')
                    ->join('actives', 'book_check_balances.active_id', '=', 'actives.id')
                    ->where($where)->whereDate('book_offer_date', '=', Carbon::parse(date('Y-m-d', strtotime(strtr($request->offer_date, '/', '-')))))->orderBy('book_check_balances.id', 'asc')->paginate(10);

                return view('balance.list', [
                    'balances' => $balances,
                    'offer_items' => $offer_items
                ]);

            } catch (QueryException $e) {
                return view('error.index')->with('error', $e->getMessage());
            } catch (Exception $e) {
                return view('error.index')->with('error', $e->getMessage());
            }
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
        try {


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
            DB::table('book_check_balances')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('BalancesController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }
}

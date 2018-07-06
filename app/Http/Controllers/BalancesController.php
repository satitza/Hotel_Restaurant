<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\Offers;
use DB;
use App\Actives;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $GLOBALS['controller'] = 'BalancesController';
        $GLOBALS['enable'] = 1;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $offer_items = $this->GetOfferItem();
            $balances = DB::table('book_check_balances')
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
        $offer_id = null;
        $offer_date = null;
        $time_type = null;

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

        if (!isset($request->time_type)) {
            $time_type = '';
        } else {
            $time_type = $request->time_type;
        }

        try {
            $offer_items = $this->GetOfferItem();
            $balances = DB::table('book_check_balances')
                ->select('book_check_balances.id', 'book_offer_id', 'offers.offer_name_en', 'book_time_type',
                    'book_offer_date', 'book_offer_guest', 'book_offer_balance', 'active')
                ->join('offers', 'book_check_balances.book_offer_id', '=', 'offers.id')
                ->join('actives', 'book_check_balances.active_id', '=', 'actives.id')
                ->where('book_offer_id', 'like', '%' . $offer_id . '%')
                ->where('book_offer_date', 'like', '%' . $offer_date . '%')
                ->where('book_time_type', 'like', '%' . $time_type . '%')
                ->orderBy('book_check_balances.id', 'asc')->get();

            return view('balance.search', [
                'balances' => $balances,
                'offer_items' => $offer_items
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

            $actives = $this->GetActiveItem();
            $balances = DB::table('book_check_balances')
                ->select('book_check_balances.id', 'book_offer_id', 'offers.offer_name_en', 'book_time_type',
                    'book_offer_date', 'book_offer_guest', 'book_offer_balance', 'book_check_balances.active_id', 'active')
                ->join('offers', 'book_check_balances.book_offer_id', '=', 'offers.id')
                ->join('actives', 'book_check_balances.active_id', '=', 'actives.id')
                ->where('book_check_balances.id', $id)->first();

            return view('balance.edit', [
                'balances' => $balances,
                'actives' => $actives
            ]);

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
        DB::beginTransaction();
        try {
            DB::table('book_check_balances')
                ->where('id', $id)
                ->update([
                    'active_id' => $request->active_id,
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

            DB::commit();
            return redirect()->action('BalancesController@create');
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
        /*DB::beginTransaction();
        try {
            DB::table('book_check_balances')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('BalancesController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }*/
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
    public function GetOfferItem()
    {
        return Offers::select('id', 'offer_name_en')->where('active_id', $GLOBALS['enable'])->get();
    }

    /**
     * @return mixed
     */
    public function GetActiveItem()
    {
        return Actives::orderBy('id', 'ASC')->get();
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use App\ActionLog;
use App\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\HotelsRequest;
use App\Hotels;
use App\Actives;
use Symfony\Component\Finder\Glob;

class HotelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'store',
            //'searchHotel',
            'edit',
            'update',
            'destroy'
        ]]);

        $GLOBALS['controller'] = 'HotelController';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $payments = $this->GetPaymentsItems();
                $actives = $this->GetActivesItems();
                return view('hotel.index', [
                    'payments' => $payments,
                    'actives' => $actives,
                ]);
            }

        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show list hotel from database
     **/
    public function create()
    {
        try {
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotel_items = $this->GetHotelsItems();
                $hotels = DB::table('hotels')
                    ->select('hotels.id', 'hotel_name', 'hotels.mid', 'hotels.secret_key', 'actives.active', 'hotel_comment')
                    ->join('actives', 'hotels.active_id', '=', 'actives.id')
                    ->where('active_id', 1)->orderBy('hotels.id', 'asc')->paginate(10);
                return view('hotel.list', [
                    'hotel_items' => $hotel_items,
                    'hotels' => $hotels
                ]);
            }

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param HotelsRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(HotelsRequest $request)
    {
        DB::beginTransaction();
        try {
            $hotel = new Hotels;
            $hotel->hotel_name = $request->hotel_name;
            $hotel->mid = $request->mid;
            $hotel->secret_key = $request->secret_key;
            $hotel->active_id = $request->active_id;
            $hotel->hotel_comment = $request->hotel_comment;
            $hotel->save();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function searchHotel(Request $request)
    {
        try {
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotel_items = $this->GetHotelsItems();
                $where = ['hotels.id' => $request->hotel_id, 'hotels.active_id' => 1];
                $hotels = DB::table('hotels')
                    ->select('hotels.id', 'hotel_name', 'hotels.mid', 'hotels.secret_key', 'actives.active', 'hotel_comment')
                    ->join('actives', 'hotels.active_id', '=', 'actives.id')
                    ->where($where)->orderBy('hotels.hotel_name', 'ASC')->paginate(10);

                return view('hotel.search', [
                    'hotel_items' => $hotel_items,
                    'hotels' => $hotels
                ]);
            }
        } catch (QueryException $e) {
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
        //
    }

    /*
      Query hotel where id and return to view edit page
     */

    public function edit($id)
    {
        try {
            if (Auth::user()->user_role != 1) {
                return view('error.index')->with('error', 'You don`t have permission');
            } else {
                $hotels = DB::table('hotels')
                    ->select('hotels.id', 'hotel_name', 'hotels.mid', 'hotels.secret_key', 'hotels.active_id', 'actives.active', 'hotel_comment')
                    ->join('actives', 'hotels.active_id', '=', 'actives.id')
                    ->orderBy('hotels.id', 'asc')->where('hotels.id', $id)->first();

                $actives = $this->GetActivesItems();
                return view('hotel.edit', [
                    'hotel_id' => $hotels->id,
                    'hotel_name' => $hotels->hotel_name,
                    'mid' => $hotels->mid,
                    'secret_key' => $hotels->secret_key,
                    'hotel_active_id' => $hotels->active_id,
                    'hotel_active' => $hotels->active,
                    'hotel_comment' => $hotels->hotel_comment
                ])->with('actives', $actives);
            }
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update hotel information to database
     */
    public function update(HotelsRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('hotels')
                ->where('id', $id)
                ->update([
                    'hotel_name' => $request->hotel_name,
                    'mid' => $request->mid,
                    'secret_key' => $request->secret_key,
                    'active_id' => $request->active_id,
                    'hotel_comment' => $request->hotel_comment,
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Delete hotel where id
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            DB::table('hotels')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);

            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (QueryException $e) {
            DB::rollback();
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
    public function GetHotelsItems()
    {
        return Hotels::select('id', 'hotel_name')->where('hotels.active_id', 1)->orderBy('hotel_name', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetPaymentsItems()
    {
        return Payment::orderBy('id', 'ASC')->get();
    }

    /**
     * @return mixed
     */
    public function GetActivesItems()
    {
        return Actives::orderBy('id', 'ASC')->get();
    }

}

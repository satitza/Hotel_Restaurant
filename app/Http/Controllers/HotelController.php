<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\HotelsRequest;
use App\Hotels;
use App\Actives;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('hotel.index', [
                'actives' => $actives,
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /*
      Show list hotel from database
     */

    public function create()
    {
        try {
            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $hotels = DB::table('hotels')
                ->select('hotels.id', 'hotel_name', 'actives.active', 'hotel_comment')
                ->join('actives', 'hotels.active_id', '=', 'actives.id')
                ->orderBy('hotels.id', 'asc')->paginate(10);
            return view('hotel.list', [
                'hotel_items' => $hotel_items,
                'hotels' => $hotels
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /*
      Insert hotel information into database
     */

    public function store(HotelsRequest $request)
    {
        DB::beginTransaction();
        try {
            $hotel = new Hotels;
            $hotel->hotel_name = $request->hotel_name;
            $hotel->active_id = $request->active_id;
            $hotel->hotel_comment = $request->hotel_comment;
            $hotel->save();
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
            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('id', 'ASC')->get();
            $hotels = DB::table('hotels')
                ->select('hotels.id', 'hotel_name', 'actives.active', 'hotel_comment')
                ->join('actives', 'hotels.active_id', '=', 'actives.id')
                ->where('hotels.id', $request->hotel_id)->orderBy('hotels.hotel_name', 'ASC')->paginate(10);
            return view('hotel.list', [
                'hotel_items' => $hotel_items,
                'hotels' => $hotels
            ]);
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
            $hotels = DB::table('hotels')
                ->select('hotels.id', 'hotel_name', 'hotels.active_id', 'actives.active', 'hotel_comment')
                ->join('actives', 'hotels.active_id', '=', 'actives.id')
                ->orderBy('hotels.id', 'asc')->where('hotels.id', $id)->first();

            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('hotel.edit', [
                'hotel_id' => $hotels->id,
                'hotel_name' => $hotels->hotel_name,
                'hotel_active_id' => $hotels->active_id,
                'hotel_active' => $hotels->active,
                'hotel_comment' => $hotels->hotel_comment
            ])->with('actives', $actives);
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
                    'active_id' => $request->active_id,
                    'hotel_comment' => $request->hotel_comment
                ]);
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /*
      Delete hotel where id
     */

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('hotels')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

}

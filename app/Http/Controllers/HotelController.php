<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests\HotelsRequest;
use App\Hotels;
use App\Actives;

class HotelController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('editor', ['only' => [
            'index',
            'store',
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
    public function index() {
        try {
            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('hotel.index', [
                'actives' => $actives,
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /*
      Show list hotel from database
     */

    public function create() {
        try {
            $hotels = DB::table('hotels')
                            ->select('hotels.id', 'hotel_name', 'actives.active', 'hotel_comment')
                            ->join('actives', 'hotels.active_id', '=', 'actives.id')
                            ->orderBy('hotels.id', 'asc')->paginate(10);
            return view('hotel.list', [
                'hotels' => $hotels
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /*
      Insert hotel information into database
     */

    public function store(HotelsRequest $request) {
        DB::beginTransaction();
        try {
            $hotel = new Hotels;
            $hotel->hotel_name = $request->hotel_name;
            $hotel->active_id = $request->active_id;
            $hotel->hotel_comment = $request->hotel_comment;
            $hotel->save();
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /*
      Query hotel where id and return to view edit page
     */

    public function edit($id) {
        try {
            $hotels = DB::table('hotels')
                            ->select('hotels.id', 'hotel_name', 'hotels.active_id', 'actives.active', 'hotel_comment')
                            ->join('actives', 'hotels.active_id', '=', 'actives.id')
                            ->orderBy('hotels.id', 'asc')->where('hotels.id', $id)->get();
            foreach ($hotels as $hotel) {
                
            }
            $actives = Actives::orderBy('id', 'ASC')->get();
            return view('hotel.edit', [
                        'hotel_id' => $hotel->id,
                        'hotel_name' => $hotel->hotel_name,
                        'hotel_active_id' => $hotel->active_id,
                        'hotel_active' => $hotel->active,
                        'hotel_comment' => $hotel->hotel_comment
                    ])->with('actives', $actives);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /**
      Update hotel information to database
     */
    public function update(HotelsRequest $request, $id) {

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
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

    /*
      Delete hotel where id
     */

    public function destroy($id) {
        DB::beginTransaction();
        try {
            DB::table('hotels')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

}

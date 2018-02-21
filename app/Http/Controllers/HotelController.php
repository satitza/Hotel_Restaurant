<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Hotels;
use App\Actives;

class HotelController extends Controller {

    public function __construct() {
        $this->middleware('auth');
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
            echo $e->getMessage();
        }
    }

    /*
      Show list hotel from database
     */

    public function create() {
        try {
            $hotels = DB::table('hotels')->orderBy('id', 'asc')->paginate(10);
            return view('hotel.list', [
                'hotels' => $hotels
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /*
      Insert hotel information into database
     */

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $hotel = new Hotels;
            $hotel->hotel_name = $request->hotel_name;
            $hotel->active = $request->active_id;
            $hotel->hotel_comment = $request->hotel_comment;
            $hotel->save();
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
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
            $hotels = Hotels::find($id);
            return view('hotel.edit', [
                'hotel_id' => $hotels->id,
                'hotel_name' => $hotels->hotel_name,
                'active' => $hotels->active,
                'hotel_comment' => $hotels->hotel_comment
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
      Update hotel information to database
     */
    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            DB::table('hotels')
                    ->where('id', $id)
                    ->update([
                        'hotel_name' => $request->hotel_name,
                        'hotel_address' => $request->hotel_address,
                        'hotel_comment' => $request->hotel_comment
            ]);
            DB::commit();
            return redirect()->action('HotelController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
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
            echo $e->getMessage();
        }
    }

}

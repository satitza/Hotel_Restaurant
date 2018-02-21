<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Hotels;

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
        return view('hotel.index');
    }

    /*
      Show list hotel from database
     */

    public function create() {
        try {
            $hotels = Hotels::paginate(10);
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
            $hotel->hotel_address = $request->hotel_address;
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
                'hotel_address' => $hotels->hotel_address,
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

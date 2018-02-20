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
            $hotels = Hotels::paginate(5);
            return view('hotel.list', [
                'hotels' => $hotels
            ]);
        } catch (Exception $e) {
            echo $e;
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
            return view('hotel.list');
        } catch (Exception $e) {
            DB::rollback();
            echo $e;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}

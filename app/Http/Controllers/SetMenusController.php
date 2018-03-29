<?php

namespace App\Http\Controllers;

use App\Language;
use App\UserEditor;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests\SetMenusRequest;
use App\User;
use App\Hotels;
use App\Restaurants;
use App\TimeLunch;
use App\TimeDinner;
use App\SetMenu;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SetMenusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            //'index',
            //'SearchMenu',
            //'create',
            //'store',
            //'edit',
            //'update',
            'destroy',
            'DeleteImage'
        ]]);
        $this->middleware('editor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $languages = Language::orderBy('id', 'ASC')->get();
            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            //User Editor
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::where($where)->get());
                    }
                }
                return view('set_menu.editor.index', [
                    //'hotels' => $hotels,
                    'restaurants' => $restaurants,
                    'languages' => $languages,
                    'time_lunchs' => $time_lunchs,
                    'time_dinners' => $time_dinners
                ]);
            } else {
                $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
                return view('set_menu.admin.index', [
                    //'hotels' => $hotels,
                    'restaurants' => $restaurants,
                    'languages' => $languages,
                    'time_lunchs' => $time_lunchs,
                    'time_dinners' => $time_dinners
                ]);
            }
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function SearchMenu(Request $request)
    {
        try {

            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name')->get();
            $menu_items = SetMenu::select('id', 'menu_name')->orderBy('menu_name', 'ASC')->get();
            $language_items = Language::orderBy('id', 'ASC')->get();
            $where = null;

            if ($request->search_value == 'hotel') {
                $where = ['set_menus.hotel_id' => $request->hotel_id];
            } elseif ($request->search_value == 'restaurant') {
                $where = ['set_menus.restaurant_id' => $request->restaurant_id];
            } elseif ($request->search_value == 'menu') {
                $where = ['set_menus.id' => $request->menu_id];
            } else {
                $where = ['set_menus.language_id' => $request->language_id];
            }

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            if ($check_rows->user_role == 2) {

                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    //echo $id->restaurant_id."<br>";
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::where($where)->get());
                    }
                }
                $set_menus = DB::table('set_menus')->
                select('set_menus.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'menu_name', 'image', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                    ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                    ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                    ->orderBy('set_menus.id', 'asc')->where('set_menus.restaurant_id', $request->restaurant_id)->paginate(10);

                return view('set_menu.editor.list', [
                    'set_menus' => $set_menus
                ])->with('restaurants', $restaurants);

            } else {
                $set_menus = DB::table('set_menus')->
                select('set_menus.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                    'menu_name', 'image', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                    ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                    ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                    ->where($where)->paginate(10);

                return view('set_menu.admin.list', [
                    'hotel_items' => $hotel_items,
                    'restaurant_items' => $restaurant_items,
                    'menu_items' => $menu_items,
                    'language_items' => $language_items,
                    'set_menus' => $set_menus
                ]);
            }

        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        try {

            $hotel_items = Hotels::select('id', 'hotel_name')->orderBy('hotel_name', 'ASC')->get();
            $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name')->get();
            $menu_items = SetMenu::select('id', 'menu_name')->orderBy('menu_name', 'ASC')->get();
            $language_items = Language::orderBy('id', 'ASC')->get();

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            //Editor User
            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($restaurant_id) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($restaurant_id as $id) {
                        $arrays = explode(',', $id->restaurant_id, -1);
                        foreach ($arrays as $array) {
                            $where = ['id' => $array];
                            array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());
                        }

                        return view('set_menu.editor.editor_info', [
                            'restaurants' => $restaurants,
                        ]);
                    }
                }

            } else {

                $set_menus = DB::table('set_menus')
                    ->select('set_menus.id', 'hotels.hotel_name', 'restaurants.restaurant_name',
                        'menu_name', 'image', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                        'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                        'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                    ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                    ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                    ->orderBy('set_menus.id', 'asc')->paginate(10);
                return view('set_menu.admin.list', [
                    'hotel_items' => $hotel_items,
                    'restaurant_items' => $restaurant_items,
                    'menu_items' => $menu_items,
                    'language_items' => $language_items,
                    'set_menus' => $set_menus
                ]);
            }
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(SetMenusRequest $request)
    {
        if ($request->input('date_check_box') == null) {
            return view('error.index')->with('error', 'You never set date select');
        } elseif (Input::hasFile('image')) {
            DB::beginTransaction();
            try {
                $get_hotel_id = Restaurants::find($request->restaurant_id);

                $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/images');

                $set_menu = new SetMenu;
                $set_menu->hotel_id = $get_hotel_id->hotel_id;
                $set_menu->restaurant_id = $request->restaurant_id;
                $set_menu->language_id = (int)$request->language_id;
                $set_menu->menu_name = $request->menu_name;
                $set_menu->image = $filename;
                $set_menu->menu_date_start = Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_start, '/', '-'))));
                $set_menu->menu_date_end = Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_end, '/', '-'))));
                //$set_menu->menu_date_select = json_encode($request->input('date_check_box'));
                $set_menu->menu_date_select = implode(", ", $request->input('date_check_box')) . ",";
                $set_menu->menu_time_lunch_start = $request->menu_time_lunch_start;
                $set_menu->menu_time_lunch_end = $request->menu_time_lunch_end;
                $set_menu->menu_time_dinner_start = $request->menu_time_dinner_start;
                $set_menu->menu_time_dinner_end = $request->menu_time_dinner_end;
                $set_menu->menu_price = $request->menu_price;
                $set_menu->menu_guest = $request->menu_guest;
                $set_menu->menu_comment = $request->set_menu_comment;
                $set_menu->save();
                DB::commit();
                $request->file('image')->move($destinationPath, $filename);
                return redirect()->action('SetMenusController@create');
            } catch (Exception $e) {
                DB::rollback();
                return view('error.index')->with('error', $e);
            }
        } else {
            return view('error.index')->with('error', 'Images is not upload');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        try {

            $restaurants = array();
            $time_lunchs = TimeLunch::orderBy('id', 'ASC')->get();
            $time_dinners = TimeDinner::orderBy('id', 'ASC')->get();
            $set_menus = DB::table('set_menus')
                ->select('set_menus.id', 'hotels.hotel_name',
                    'set_menus.restaurant_id', 'restaurants.restaurant_name',
                    'menu_name', 'image', 'menu_date_start', 'menu_date_end', 'menu_date_select',
                    'menu_time_lunch_start', 'menu_time_lunch_end', 'menu_time_dinner_start',
                    'menu_time_dinner_end', 'menu_price', 'menu_guest', 'menu_comment')
                ->join('hotels', 'set_menus.hotel_id', '=', 'hotels.id')
                ->join('restaurants', 'set_menus.restaurant_id', '=', 'restaurants.id')
                ->where('set_menus.id', $id)->get();

            foreach ($set_menus as $set_menu) {
            }

            $date_start_format = date('d/m/Y', strtotime($set_menu->menu_date_start));
            $date_end_format = date('d/m/Y', strtotime($set_menu->menu_date_end));

        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }

        $check_rows = User::find(Auth::id());

        //User editor
        if ($check_rows->user_role == 2) {
            $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
            foreach ($restaurant_id as $res_id) {
            }
            $arrays = explode(',', $res_id->restaurant_id, -1);
            foreach ($arrays as $array) {

                $where = ['id' => $array];
                array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());

            }
            foreach ($arrays as $array) {
                if ($set_menu->restaurant_id == $array) {
                    //Editor user role
                    return view('set_menu.editor.edit', [
                        'set_menu_id' => $set_menu->id,
                        'hotel_name' => $set_menu->hotel_name,
                        'restaurant_id' => $set_menu->restaurant_id,
                        'restaurant_name' => $set_menu->restaurant_name,
                        'menu_name' => $set_menu->menu_name,
                        'old_image' => $set_menu->image,
                        'menu_date_start' => $date_start_format,
                        'menu_date_end' => $date_end_format,
                        'menu_date_select' => $set_menu->menu_date_select,
                        'menu_time_lunch_start' => $set_menu->menu_time_lunch_start,
                        'menu_time_lunch_end' => $set_menu->menu_time_lunch_end,
                        'menu_time_dinner_start' => $set_menu->menu_time_dinner_start,
                        'menu_time_dinner_end' => $set_menu->menu_time_dinner_end,
                        'menu_price' => $set_menu->menu_price,
                        'menu_guest' => $set_menu->menu_guest,
                        'menu_comment' => $set_menu->menu_comment
                    ])
                        ->with('restaurants', $restaurants)
                        ->with('time_lunchs', $time_lunchs)
                        ->with('time_dinners', $time_dinners);
                }
            }
        } else {
            //Administrator role
            $restaurants = Restaurants::orderBy('id', 'ASC')->where('active_id', '1')->get();
            return view('set_menu.admin.edit', [
                'set_menu_id' => $set_menu->id,
                'hotel_name' => $set_menu->hotel_name,
                'restaurant_id' => $set_menu->restaurant_id,
                'restaurant_name' => $set_menu->restaurant_name,
                'menu_name' => $set_menu->menu_name,
                'old_image' => $set_menu->image,
                'menu_date_start' => $date_start_format,
                'menu_date_end' => $date_end_format,
                'menu_date_select' => $set_menu->menu_date_select,
                'menu_time_lunch_start' => $set_menu->menu_time_lunch_start,
                'menu_time_lunch_end' => $set_menu->menu_time_lunch_end,
                'menu_time_dinner_start' => $set_menu->menu_time_dinner_start,
                'menu_time_dinner_end' => $set_menu->menu_time_dinner_end,
                'menu_price' => $set_menu->menu_price,
                'menu_guest' => $set_menu->menu_guest,
                'menu_comment' => $set_menu->menu_comment
            ])
                ->with('restaurants', $restaurants)
                ->with('time_lunchs', $time_lunchs)
                ->with('time_dinners', $time_dinners);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(SetMenusRequest $request, $id)
    {
        $date_insert = null;
        $filename = null;
        $new_date_select = ($request->input('date_check_box'));
        $get_hotel_id = Restaurants::find($request->restaurant_id);

        if (!isset($new_date_select)) {
            //Check box is null insert old date select
            $date_insert = $request->old_date_select;
        } else {
            //Check box not null insert new date select json
            $date_insert = implode(",", $request->input('date_check_box')) . ",";
        }

        try {

            if (Input::hasFile('image')) {
                //update and upload new file
                $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $request->file('image')->move($destinationPath, $filename);
                $this->DeleteImage($id);
            } else {
                //no update image
                $filename_obj = $get_old_image = SetMenu::find($id);
                $filename = $filename_obj->image;
            }

            DB::beginTransaction();

            DB::table('set_menus')
                ->where('id', $id)
                ->update([
                    'hotel_id' => $get_hotel_id->hotel_id,
                    'restaurant_id' => $request->restaurant_id,
                    'menu_name' => $request->menu_name,
                    'image' => $filename,
                    'menu_date_start' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_start, '/', '-')))),
                    'menu_date_end' => Carbon::parse(date('Y-m-d', strtotime(strtr($request->menu_date_end, '/', '-')))),
                    'menu_date_select' => $date_insert,
                    'menu_time_lunch_start' => $request->menu_time_lunch_start,
                    'menu_time_lunch_end' => $request->menu_time_lunch_end,
                    'menu_time_dinner_start' => $request->menu_time_dinner_start,
                    'menu_time_dinner_end' => $request->menu_time_dinner_end,
                    'menu_price' => $request->menu_price,
                    'menu_guest' => $request->menu_guest,
                    'menu_comment' => $request->menu_comment
                ]);
            DB::commit();
            return redirect()->action('SetMenusController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->DeleteImage($id);
            DB::table('set_menus')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('SetMenusController@create');
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
        }
    }

    public function DeleteImage($id)
    {
        try {
            $get_old_image = SetMenu::find($id);
            return File::delete(public_path('images\\' . $get_old_image->image));
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        }
    }

}

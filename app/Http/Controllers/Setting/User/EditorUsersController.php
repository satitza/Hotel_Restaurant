<?php

namespace App\Http\Controllers\Setting\User;

use DB;
use App\User;
use App\Restaurants;
use App\UserEditor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'create',
            'store',
            'AddRestaurant',
            'UpdateAddRestaurant',
            'show',
            'edit',
            'update',
            'destroy'
        ]]);
    }

    public function index()
    {
        try {
            $editor_users = User::where('user_role', 2)->orderBy('id', 'ASC')->get();
            $restaurants = Restaurants::where('active_id', 1)->orderBy('id', 'ASC')->get();

            return view('setting.editor_user.add_user', [
                'editor_users' => $editor_users,
                'restaurants' => $restaurants
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $user_editors = DB::table('user_editors')
                ->select('user_editors.id', 'user_id', 'users.name', 'restaurant_id')
                ->join('users', 'user_editors.user_id', '=', 'users.id')
                ->orderBy('user_editors.id', 'asc')->paginate(10);

            $collect = array();
            foreach ($user_editors as $user_editor) {
                $arrays = explode(',', $user_editor->restaurant_id, -1);
                array_push($collect, DB::table('restaurants')->select('restaurant_name')->whereIn('id', $arrays)->get());
            }

            return view('setting.editor_user.list_user', [
                'user_editors' => $user_editors,
                'restaurants' => $collect
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    /*public function object_to_array($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = $this->object_to_array($value);
            }
            return $result;
        }
        return $data;
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            if (DB::table('user_editors')->where('user_id', '=', $request->user_id)->exists()) {
                return view('error.index')->with('error', 'เคยทำการ Match User คนนี้แล้ว');
            }

            $user_editor = new UserEditor;
            $user_editor->user_id = $request->user_id;
            $user_editor->restaurant_id = implode(",", $request->input('restaurants_check_box')) . ",";
            $user_editor->save();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

    public function AddRestaurant($id)
    {
        try {
            $restaurants = Restaurants::where('active_id', 1)->orderBy('id', 'ASC')->get();
            $user_editors = DB::table('user_editors')
                ->select('user_editors.id', 'user_id', 'users.name', 'restaurant_id')
                ->join('users', 'user_editors.user_id', '=', 'users.id')
                ->where('user_editors.id', $id)->get();

            foreach ($user_editors as $user_editor) {
            }

            return view('setting.editor_user.add_restaurant', [
                'id' => $user_editor->id,
                'user_id' => $user_editor->user_id,
                'user_name' => $user_editor->name
            ])->with('restaurants', $restaurants);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function UpdateAddRestaurant(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $old_restaurants_id = DB::table('user_editors')->select('restaurant_id')->where('id', $id)->get()->toArray();
            foreach ($old_restaurants_id as $old_restaurant_id) {
                $arrays = explode(',', $old_restaurant_id->restaurant_id, -1);
                foreach ($arrays as $array) {
                    if ($request->restaurant_id == $array) {
                        return view('error.index')->with('error', 'User คนนี้ใด้ทำการ Match กับร้านอาหารนี้แล้ว');
                    }
                }
            }

            array_push($arrays, $request->restaurant_id);

            DB::table('user_editors')
                ->where('id', $id)
                ->update([
                    'restaurant_id' => implode(",", $arrays) . ","
                ]);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $user_editors = DB::table('user_editors')
                ->select('user_editors.id', 'user_id', 'users.name', 'restaurant_id')
                ->join('users', 'user_editors.user_id', '=', 'users.id')
                ->where('user_editors.id', '=', $id)->get();

            $old_restaurants = array();
            $old_restaurants_id = array();

            foreach ($user_editors as $user_editor) {
                $old_restaurants_id = explode(',', $user_editor->restaurant_id, -1);
                foreach ($old_restaurants_id as $old_restaurant_id) {
                    array_push($old_restaurants, DB::table('restaurants')->select('id', 'restaurant_name')->where('id', $old_restaurant_id)->get());
                }
            }

            return view('setting.editor_user.edit_user', [
                'id' => $user_editor->id,
                'user_id' => $user_editor->user_id,
                'user_name' => $user_editor->name,
                'old_restaurants' => $old_restaurants,
                'old_restaurants_id' => $old_restaurants_id
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
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
            DB::table('user_editors')
                ->where('id', $id)
                ->update([
                    'restaurant_id' => implode(",", $request->input('old_restaurants_check_box')) . ","
                ]);
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
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
            DB::table('user_editors')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }
}

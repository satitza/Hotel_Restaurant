<?php

namespace App\Http\Controllers\Setting\User;

use App\ActionLog;
use DB;
use App\User;
use App\Restaurants;
use App\UserEditor;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $GLOBALS['enable'] = 1;
        $GLOBALS['controller'] = 'EditorUsersController';

    }

    public function index()
    {
        try {
            $editor_users = User::where('user_role', 2)->orderBy('id', 'ASC')->get();
            $restaurants = Restaurants::where('active_id', 1)->orderBy('restaurant_name', 'ASC')->get();

            return view('setting.editor_user.add_user', [
                'editor_users' => $editor_users,
                'restaurants' => $restaurants
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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
            $echo = null;
            $user_editors = DB::table('user_editors')
                ->select('user_editors.id', 'user_id', 'users.name', 'restaurant_id')
                ->join('users', 'user_editors.user_id', '=', 'users.id')
                ->orderBy('user_editors.id', 'asc')->paginate(10);

            $arrays = [];
            foreach ($user_editors as $user_editor) {
                $arrays = explode(',', $user_editor->restaurant_id, -1);
                //array_push($collect, DB::table('restaurants')->select('id', 'restaurant_name')->whereIn('id', $arrays)->get());
            }
            $restaurants = Restaurants::select('restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();

            return view('setting.editor_user.list_user', [
                'user_editors' => $user_editors,
                'restaurants' => $restaurants
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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

            if ($request->input('restaurants_check_box') == null) {
                return view('error.index')->with('error', 'Please select restaurant');
            } else if (DB::table('user_editors')->where('user_id', '=', $request->user_id)->exists()) {
                return view('error.index')->with('error', 'You matched this restaurant');
            }

            $user_editor = new UserEditor;
            $user_editor->user_id = $request->user_id;
            $user_editor->restaurant_id = implode(",", $request->input('restaurants_check_box')) . ",";
            $user_editor->save();

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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

            $arrays = [];
            foreach ($user_editors as $user_editor) {
                $arrays = explode(',', $user_editor->restaurant_id, -1);
            }
            $old_restaurants = Restaurants::select('restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();

            return view('setting.editor_user.add_restaurant', [
                'id' => $user_editor->id,
                'user_id' => $user_editor->user_id,
                'user_name' => $user_editor->name,
                'restaurants' => $restaurants,
                'old_restaurants' => $old_restaurants
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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
                        return view('error.index')->with('error', 'This user is matched with restaurant');
                    }
                }
            }

            array_push($arrays, $request->restaurant_id);

            DB::table('user_editors')
                ->where('id', $id)
                ->update([
                    'restaurant_id' => implode(",", $arrays) . ",",
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'UpdateAddRestaurant', $id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
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

            $user_id = null;
            $user_name = null;

            $arrays = array();
            foreach ($user_editors as $user_editor) {
                $arrays = explode(',', $user_editor->restaurant_id, -1);
                $user_id = $user_editor->user_id;
                $user_name = $user_editor->name;
                //array_push($collect, DB::table('restaurants')->select('id', 'restaurant_name')->whereIn('id', $arrays)->get());
            }
            $restaurants = Restaurants::select('id as restaurant_id', 'restaurant_name')->whereIn('id', $arrays)->where('active_id', $GLOBALS['enable'])->get();

            return view('setting.editor_user.edit_user', [
                'id' => $id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'restaurants' => $restaurants
                //'old_restaurants' => $old_restaurants,
                //'old_restaurants_id' => $old_restaurants_id
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
        if ($request->input('old_restaurants_check_box') == null) {
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
        }

        DB::beginTransaction();
        try {
            DB::table('user_editors')
                ->where('id', $id)
                ->update([
                    'restaurant_id' => implode(",", $request->input('old_restaurants_check_box')) . ",",
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
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
    public
    function destroy($id)
    {
        DB::beginTransaction();
        try {

            DB::table('user_editors')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\EditorUsersController@create');
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
}

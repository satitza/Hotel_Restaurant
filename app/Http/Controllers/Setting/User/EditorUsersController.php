<?php

namespace App\Http\Controllers\Setting\User;

use DB;
use App\User;
use App\Restaurants;
use App\UserEditor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function PHPSTORM_META\type;

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

            /*foreach ($restaurants as $restaurant) {
                $all_data[] = $restaurant->id;
                $all_data[] = $restaurant->restaurant_name;
            }*/

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

            /*foreach ($user_editors as $user_editor){
                $array = explode(',',$user_editor->restaurant_id,-1);
            }



            print_r($array);*/

            return view('setting.editor_user.list_user', [
                'user_editors' => $user_editors
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
            $user_editor->restaurant_id = implode(",", $request->input('restaurants_check_box'));
            $user_editor->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Setting\User;

use DB;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'index',
            'create',
            'store'
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
            $roles = UserRole::orderBy('id', 'ASC')->get();
            return view('setting.user.add_user')->with('roles', $roles);
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
            $users = DB::table('users')
                ->select('users.id', 'name', 'email', 'user_roles.role', 'users.user_role')
                ->join('user_roles', 'users.user_role', '=', 'user_roles.id')
                //->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->orderBy('users.id', 'asc')->paginate(10);
            return view('setting.user.list_user')->with('users', $users);
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (DB::table('users')->where('email', '=', $request->user_email)->exists()) {
                return view('error.index')->with('error', 'มี E-Mail นี้อยู่ในระบบแล้ว');
            }
            $users = new User;
            $users->name = $request->user_name;
            $users->email = $request->user_email;
            $users->password = bcrypt($request->user_password);
            $users->user_role = $request->user_role;
            $users->save();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
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

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
            'store',
            'edit',
            'update',
            'destroy',
            'show',
            'update_password'
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
                ->select('users.id', 'name', 'email', 'user_roles.role')
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
        try {
            $old_pass = DB::table('users')->where('id', '=', $id)->get();
            foreach ($old_pass as $password) {

            }
            return view('setting.user.reset_password', [
                'user_id' => $password->id,
                'user_name' => $password->name,
                'password' => $password->password
            ]);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function update_password(Request $request)
    {
        if ($request->user_password_1 != $request->user_password_2) {
            return view('error.index')->with('error', 'คุณกรอกรหัสผ่านไม่ตรงกัน');
        }
        DB::beginTransaction();
        try {
            DB::table('users')
                ->where('id', $request->user_id)
                ->update([
                    'password' => bcrypt($request->user_password_1)
                ]);
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
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
            $roles = UserRole::orderBy('id', 'ASC')->get();
            $users = DB::table('users')
                ->select('users.id', 'name', 'email', 'users.user_role', 'user_roles.role')
                ->join('user_roles', 'users.user_role', '=', 'user_roles.id')
                ->where('users.id', $id)->get();
            foreach ($users as $user) {
            }

            return view('setting.user.edit_user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role_id' => $user->user_role,
                'user_role' => $user->role
            ])->with('roles', $roles);
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
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'user_role' => $request->user_role
                ]);
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
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
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('users')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }
}

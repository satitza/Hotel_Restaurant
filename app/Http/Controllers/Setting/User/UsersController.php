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

    public function index()
    {
        try {
            $roles = UserRole::orderBy('id', 'ASC')->get();
            return view('setting.user.add_user')->with('roles', $roles);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function create()
    {

    }

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
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@index');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

}

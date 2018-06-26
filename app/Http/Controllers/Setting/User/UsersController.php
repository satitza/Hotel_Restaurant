<?php

namespace App\Http\Controllers\Setting\User;

use App\ActionLog;
use DB;
use App\User;
use Carbon\Carbon;
use App\UserRole;
use Illuminate\Database\QueryException;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        $GLOBALS['controller'] = 'UsersController';

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
            $users = DB::table('users')
                ->select('users.id', 'name', 'email', 'user_roles.role')
                ->join('user_roles', 'users.user_role', '=', 'user_roles.id')
                //->join('actives', 'restaurants.active_id', '=', 'actives.id')
                ->orderBy('users.id', 'asc')->paginate(10);
            return view('setting.user.list_user')->with('users', $users);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
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

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
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
        try {
            $passwords = User::find($id);
            return view('setting.user.reset_password', [
                'user_id' => $passwords->id,
                'user_name' => $passwords->name,
                'password' => $passwords->password
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function update_password(UsersRequest $request)
    {
        if ($request->user_password != $request->user_password_2) {
            return view('error.index')->with('error', 'Passwords do not match');
        }
        DB::beginTransaction();
        try {
            DB::table('users')
                ->where('id', $request->user_id)
                ->update([
                    'password' => bcrypt($request->user_password),
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update_password', $request->user_id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
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
            $users = DB::table('users')
                ->select('users.id', 'name', 'email', 'users.user_role', 'user_roles.role')
                ->join('user_roles', 'users.user_role', '=', 'user_roles.id')
                ->where('users.id', $id)->first();

            return view('setting.user.edit_user', [
                'user_id' => $users->id,
                'user_name' => $users->name,
                'user_email' => $users->email,
                'user_role_id' => $users->user_role,
                'user_role' => $users->role
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
    public function update(UsersRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->user_name,
                    'email' => $request->user_email,
                    'user_role' => $request->user_role,
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
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
    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            DB::table('users')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'destroy', $id);

            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\UsersController@create');
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

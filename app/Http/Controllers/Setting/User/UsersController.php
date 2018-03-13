<?php

namespace App\Http\Controllers\Setting\User;

use DB;
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
            'store'
        ]]);
    }

    public function index(){
        try{
            $roles = UserRole::orderBy('id', 'ASC')->get();
            return view('setting.user.add_user')->with('roles', $roles);
        }
        catch (Exception $e){
            return view('error.index')->with('error', $e);
        }
    }

    public function store(Request $request){

    }
}

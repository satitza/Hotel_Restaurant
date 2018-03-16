<?php

namespace App\Http\Controllers\Setting\User;

use DB;
use App\User;
use App\Restaurants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Array_;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $restaurants = $request->input('restaurants_check_box');

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

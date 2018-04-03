<?php

namespace App\Http\Controllers\Setting\User;

use App\UserReport;
use DB;
use App\User;
use App\Hotels;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportUsersController extends Controller
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
            'destroy('
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
            $report_users = User::where('user_role', 3)->orderBy('id', 'ASC')->get();
            $hotels = Hotels::where('active_id', 1)->orderBy('id', 'ASC')->get();

            return view('setting.report_user.add_user', [
                'report_users' => $report_users,
                'hotels' => $hotels
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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
            $user_ports = DB::table('user_reports')
                ->select('user_reports.id', 'user_id', 'users.name', 'hotel_id', 'hotels.hotel_name')
                ->join('users', 'user_reports.user_id', '=', 'users.id')
                ->join('hotels', 'user_reports.hotel_id', '=', 'hotels.id')
                ->orderBy('user_reports.id', 'asc')->paginate(10);
            return view('setting.report_user.list_user', [
                'user_reports' => $user_ports
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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
            if (DB::table('user_reports')->where('user_id', '=', $request->user_id)->exists()) {
                return view('error.index')->with('error', 'You matched this user');
            }

            $user_report = new UserReport;
            $user_report->user_id = $request->user_id;
            $user_report->hotel_id = $request->hotel_id;
            $user_report->save();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\ReportUsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
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
            $users = DB::table('user_reports')
                ->select('user_reports.id', 'user_id', 'users.name', 'hotel_id', 'hotels.hotel_name')
                ->join('users', 'user_reports.user_id', '=', 'users.id')
                ->join('hotels', 'user_reports.hotel_id', '=', 'hotels.id')
                ->where('user_reports.id', '=', $id)->get();
            foreach ($users as $user) {
            }

            $report_users = User::where('user_role', 3)->orderBy('id', 'ASC')->get();
            $hotels = Hotels::where('active_id', 1)->orderBy('id', 'ASC')->get();

            return view('setting.report_user.edit_user', [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'user_name' => $user->name,
                'hotel_id' => $user->hotel_id,
                'hotel_name' => $user->hotel_name
            ])->with([
                'report_users' => $report_users,
                'hotels' => $hotels
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
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
            DB::table('user_reports')
                ->where('id', $id)
                ->update([
                    'user_id' => $request->user_id,
                    'hotel_id' => $request->hotel_id,
                ]);
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\ReportUsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
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
            DB::table('user_reports')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('\App\Http\Controllers\Setting\User\ReportUsersController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }
}

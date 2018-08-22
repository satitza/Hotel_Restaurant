<?php

namespace App\Http\Controllers;

use App\ActionLog;
use DB;
use App\Termscn;
use App\Termsen;
use App\Offers;
use App\Termsth;
use Carbon\Carbon;
use App\User;
use App\UserEditor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            //'term_th_delete',
            //'term_en_delete',
            //'term_cn_delete'
        ]]);
        $this->middleware('editor');

        $GLOBALS['controller'] = 'TermsController';

    }

    public function index($offer_id)
    {
        try {

            $offers = null;
            $offer_name_en = null;

            if (Auth::user()->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->first();
                $restaurants_id = explode(',', $user_editors->restaurant_id);
                foreach ($restaurants_id as $id) {
                    $where = ['id' => $offer_id, 'restaurant_id' => $id];
                    if (Offers::select('id', 'offer_name_en')->where($where)->exists()) {
                        //array_push($offer_items, Offers::select('id', 'offer_name_en')->where($where)->get());
                        $offers = Offers::select('id', 'offer_name_en')->where($where)->orderBy('id', 'ASC')->first();
                        $offer_name_en = $offers->offer_name_en;
                    }
                }

                if ($offers == null) {
                    return view('error.index')->with('error', 'Offer ID Not Found');
                }

            } else {
                if (Offers::where('id', '=', $offer_id)->exists()) {
                    $offers = Offers::select('id', 'offer_name_en')->where('id', '=', $offer_id)->first();
                    $offer_name_en = $offers->offer_name_en;
                } else {
                    return view('error.index')->with('error', 'Offer ID Not Found');
                }
            }

            return view('terms.index', [
                'offer_id' => $offer_id,
                'offer_name' => $offer_name_en
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function create($offer_id)
    {
        try {

            $offers = null;
            $offer_name_en = null;

            if (Auth::user()->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->first();
                $restaurants_id = explode(',', $user_editors->restaurant_id);
                foreach ($restaurants_id as $id) {
                    $where = ['id' => $offer_id, 'restaurant_id' => $id];
                    if (Offers::select('id', 'offer_name_en')->where($where)->exists()) {
                        //array_push($offer_items, Offers::select('id', 'offer_name_en')->where($where)->get());
                        $offers = Offers::select('id', 'offer_name_en')->where($where)->orderBy('id', 'ASC')->first();
                        $offer_name_en = $offers->offer_name_en;
                    }
                }

                if ($offers == null) {
                    return view('error.index')->with('error', 'Offer ID Not Found');
                }

            } else {
                if (Offers::select('id', 'offer_name_en')->where('id', '=', $offer_id)->exists()) {
                    $offers = Offers::select('id', 'offer_name_en')->where('id', '=', $offer_id)->first();
                    $offer_name_en = $offers->offer_name_en;
                } else {
                    return view('error.index')->with('error', 'Offer id not found');
                }
            }

            $terms_th = Termsth::where('offer_id', '=', $offer_id)->paginate(10);
            $terms_en = Termsen::where('offer_id', '=', $offer_id)->paginate(10);
            $terms_cn = Termscn::where('offer_id', '=', $offer_id)->paginate(10);

            return view('terms.list', [
                'offer_id' => $offer_id,
                'offer_name' => $offer_name_en,

                'terms_th' => $terms_th,
                'terms_en' => $terms_en,
                'terms_cn' => $terms_cn
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->term_header_th != null && $request->term_content_th != null) {
                $terms_th = new Termsth;
                $terms_th->offer_id = $request->offer_id;
                $terms_th->term_header_th = $request->term_header_th;
                $terms_th->term_content_th = $request->term_content_th;
                $terms_th->save();
            }

            if ($request->term_header_en != null && $request->term_content_en != null) {
                $terms_en = new Termsen;
                $terms_en->offer_id = $request->offer_id;
                $terms_en->term_header_en = $request->term_header_en;
                $terms_en->term_content_en = $request->term_content_en;
                $terms_en->save();
            }

            if ($request->term_header_cn != null && $request->term_content_cn != null) {
                $terms_cn = new Termscn;
                $terms_cn->offer_id = $request->offer_id;
                $terms_cn->term_header_cn = $request->term_header_cn;
                $terms_cn->term_content_cn = $request->term_content_cn;
                $terms_cn->save();
            }

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'store', '');

            DB::commit();
            return redirect()->action('TermsController@create', [$request->offer_id]);

        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Edit
     */

    public function term_th_edit($term_id, $offer_id)
    {
        try {

            $terms_th = null;

            if (Auth::user()->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->first();
                $restaurants_id = explode(',', $user_editors->restaurant_id);
                foreach ($restaurants_id as $id) {
                    $where = ['id' => $offer_id, 'restaurant_id' => $id];
                    if (Offers::select('id')->where($where)->exists()) {
                        $where = ['termsths.id' => $term_id, 'offers.id' => $offer_id];
                        $terms_th = DB::table('termsths')->select('termsths.id', 'offers.offer_name_en', 'termsths.offer_id', 'termsths.term_header_th', 'termsths.term_content_th')
                            ->join('offers', 'termsths.offer_id', '=', 'offers.id')
                            ->where($where)->first();
                    }

                    if ($terms_th == null) {
                        return view('error.index')->with('error', 'Terms & Condition not found');
                    }
                }
            } else {

                $where = ['id' => $term_id, 'offer_id' => $offer_id];
                if (Termsth::where($where)->exists()) {
                    $where = ['termsths.id' => $term_id, 'offers.id' => $offer_id];
                    $terms_th = DB::table('termsths')->select('termsths.id', 'offers.offer_name_en', 'termsths.offer_id', 'termsths.term_header_th', 'termsths.term_content_th')
                        ->join('offers', 'termsths.offer_id', '=', 'offers.id')
                        ->where($where)->first();
                } else {
                    return view('error.index')->with('error', 'Terms & Condition not found');
                }
            }

            return view('terms.edit', [
                'term_id' => $terms_th->id,
                'offer_id' => $terms_th->offer_id,
                'offer_name' => $terms_th->offer_name_en,
                'term_header' => $terms_th->term_header_th,
                'term_content' => $terms_th->term_content_th,
                'table_name' => 'termsths'
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function term_en_edit($term_id, $offer_id)
    {
        try {

            $terms_en = null;

            if (Auth::user()->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->first();
                $restaurants_id = explode(',', $user_editors->restaurant_id);
                foreach ($restaurants_id as $id) {
                    $where = ['id' => $offer_id, 'restaurant_id' => $id];
                    if (Offers::select('id')->where($where)->exists()) {
                        $where = ['termsens.id' => $term_id, 'offers.id' => $offer_id];
                        $terms_en = DB::table('termsens')->select('termsens.id', 'offers.offer_name_en', 'termsens.offer_id', 'termsens.term_header_en', 'termsens.term_content_en')
                            ->join('offers', 'termsens.offer_id', '=', 'offers.id')
                            ->where($where)->first();
                    }

                    if ($terms_en == null) {
                        return view('error.index')->with('error', 'Terms & Condition not found');
                    }
                }
            } else {

                $where = ['id' => $term_id, 'offer_id' => $offer_id];
                if (Termsen::where($where)->exists()) {
                    $where = ['termsens.id' => $term_id, 'offers.id' => $offer_id];
                    $terms_en = DB::table('termsens')->select('termsens.id', 'offers.offer_name_en', 'termsens.offer_id', 'termsens.term_header_en', 'termsens.term_content_en')
                        ->join('offers', 'termsens.offer_id', '=', 'offers.id')
                        ->where($where)->first();
                } else {
                    return view('error.index')->with('error', 'Terms & Condition not found');
                }
            }

            return view('terms.edit', [
                'term_id' => $terms_en->id,
                'offer_id' => $terms_en->offer_id,
                'offer_name' => $terms_en->offer_name_en,
                'term_header' => $terms_en->term_header_en,
                'term_content' => $terms_en->term_content_en,
                'table_name' => 'termsens'
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function term_cn_edit($term_id, $offer_id)
    {
        try {

            $terms_cn = null;

            if (Auth::user()->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->first();
                $restaurants_id = explode(',', $user_editors->restaurant_id);
                foreach ($restaurants_id as $id) {
                    $where = ['id' => $offer_id, 'restaurant_id' => $id];
                    if (Offers::select('id')->where($where)->exists()) {
                        $where = ['termscns.id' => $term_id, 'offers.id' => $offer_id];
                        $terms_cn = DB::table('termscns')->select('termscns.id', 'offers.offer_name_en', 'termscns.offer_id', 'termscns.term_header_cn', 'termscns.term_content_cn')
                            ->join('offers', 'termscns.offer_id', '=', 'offers.id')
                            ->where($where)->first();
                    }

                    if ($terms_cn == null) {
                        return view('error.index')->with('error', 'Terms & Condition not found');
                    }
                }
            } else {

                $where = ['id' => $term_id, 'offer_id' => $offer_id];
                if (Termscn::where($where)->exists()) {
                    $where = ['termscns.id' => $term_id, 'offers.id' => $offer_id];
                    $terms_cn = DB::table('termscns')->select('termscns.id', 'offers.offer_name_en', 'termscns.offer_id', 'termscns.term_header_cn', 'termscns.term_content_cn')
                        ->join('offers', 'termscns.offer_id', '=', 'offers.id')
                        ->where($where)->first();
                } else {
                    return view('error.index')->with('error', 'Terms & Condition not found');
                }
            }

            return view('terms.edit', [
                'term_id' => $terms_cn->id,
                'offer_id' => $terms_cn->offer_id,
                'offer_name' => $terms_cn->offer_name_en,
                'term_header' => $terms_cn->term_header_cn,
                'term_content' => $terms_cn->term_content_cn,
                'table_name' => 'termscns'
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }


    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $term_header = null;
            $term_content = null;

            if ($request->table_name == 'termsths') {
                $term_header = 'term_header_th';
                $term_content = 'term_content_th';
            }

            if ($request->table_name == 'termsens') {
                $term_header = 'term_header_en';
                $term_content = 'term_content_en';
            }

            if ($request->table_name == 'termscns') {
                $term_header = 'term_header_cn';
                $term_content = 'term_content_cn';
            }

            $where = ['id' => $request->term_id, 'offer_id' => $request->offer_id];
            DB::table($request->table_name)
                ->where($where)
                ->update([
                    $term_header => $request->term_header,
                    $term_content => $request->term_content,
                    'updated_at' => Carbon::now()
                ]);

            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'update', $request->term_id);

            DB::commit();

            return redirect()->action('TermsController@create', [$request->offer_id]);
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }


    /**
     * Delete
     */

    public function term_th_delete($id, $offer_id)
    {
        DB::beginTransaction();
        try {

            DB::table('termsths')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'term_th_delete', $id);

            DB::commit();
            return redirect()->action('TermsController@create', [$offer_id]);

        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function term_en_delete($id, $offer_id)
    {
        DB::beginTransaction();
        try {

            DB::table('termsens')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'term_en_delete', $id);

            DB::commit();
            return redirect()->action('TermsController@create', [$offer_id]);

        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function term_cn_delete($id, $offer_id)
    {
        DB::beginTransaction();
        try {

            DB::table('termscns')->where('id', $id)->delete();
            $this->SaveLog(Auth::id(), $GLOBALS['controller'], 'term_cn_delete', $id);

            DB::commit();
            return redirect()->action('TermsController@create', [$offer_id]);

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

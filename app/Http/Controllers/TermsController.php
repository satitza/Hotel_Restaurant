<?php

namespace App\Http\Controllers;

use DB;
use App\Termscn;
use App\Termsen;
use App\Offers;
use App\Termsth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index($id)
    {
        try {

            $offers = Offers::select('id', 'offer_name_en')->where('id', '=', $id)->first();

            return view('terms.index', [
                'offer_id' => $offers->id,
                'offer_name' => $offers->offer_name_en
            ]);

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function create($id)
    {
        try {

            if (Offers::where('id', '=', $id)->exists()) {
                $offers = Offers::select('id', 'offer_name_en')->where('id', '=', $id)->first();
                $terms_th = Termsth::where('offer_id', '=', $id)->paginate(10);
                $terms_en = Termsen::where('offer_id', '=', $id)->paginate(10);
                $terms_cn = Termscn::where('offer_id', '=', $id)->paginate(10);

                return view('terms.list', [
                    'offer_id' => $offers->id,
                    'offer_name' => $offers->offer_name_en,
                    'terms_th' => $terms_th,
                    'terms_en' => $terms_en,
                    'terms_cn' => $terms_cn
                ]);
            } else {
                return view('error.index')->with('error', 'Offer id not found');
            }

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

    public function term_th_edit($id, $offer_id)
    {
        try {
            $where = ['termsths.id' => $id, 'offers.id' => $offer_id];
            $terms_th = DB::table('termsths')->select('termsths.id', 'offers.offer_name_en', 'termsths.offer_id', 'termsths.term_header_th', 'termsths.term_content_th')
                ->join('offers', 'termsths.offer_id', '=', 'offers.id')
                ->where($where)->first();

            return view('terms.edit', [
                'term_id' => $terms_th->id,
                'offer_id' => $terms_th->offer_id,
                'offer_name' => $terms_th->offer_name_en,
                'term_header' => $terms_th->term_header_th,
                'term_content' => $terms_th->term_content_th,
            ]);
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function term_en_edit($id, $offer_id)
    {
        echo $id."<br>";
        echo $offer_id."<br>";
    }

    public function term_cn_edit($id, $offer_id)
    {
        echo $id."<br>";
        echo $offer_id."<br>";
    }


    public function update(Request $request)
    {

    }


    /**
     * Delete
     */

    public function term_th_delete($id, $offer_id)
    {
        DB::beginTransaction();
        try {

            DB::table('termsths')->where('id', $id)->delete();
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
            DB::commit();
            return redirect()->action('TermsController@create', [$offer_id]);

        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }
}

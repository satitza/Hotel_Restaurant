<?php

namespace App\Http\Controllers;

use App\Termscn;
use App\Termsen;
use DB;
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

        } catch (QueryException $e) {
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
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
            return view('error.index')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return view('error.index')->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {

    }

    public function update(Request $request)
    {

    }
}

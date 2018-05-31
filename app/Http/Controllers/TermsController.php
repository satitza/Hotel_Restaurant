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
          return view('terms.list');
    }

    public function store(Request $request)
    {
        try {

            $terms_th = new Termsth;
            $terms_th->offer_id = $request->offer_id;
            $terms_th->term_header_th = $request->term_header_th;
            $terms_th->term_content_th = $request->term_content_th;
            $terms_th->save();

            $terms_en = new Termsen;
            $terms_en->offer_id = $request->offer_id;
            $terms_en->term_header_en = $request->term_header_en;
            $terms_en->term_content_en = $request->term_content_en;
            $terms_en->save();

            $terms_cn = new Termscn;
            $terms_cn->offer_id = $request->offer_id;
            $terms_cn->term_header_cn = $request->term_header_cn;
            $terms_cn->term_content_cn = $request->term_content_cn;
            $terms_cn->save();


            DB::commit();
            return redirect()->action('OffersController@create');

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

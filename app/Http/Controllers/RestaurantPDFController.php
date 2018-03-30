<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use File;
use App\Restaurants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\RestaurantPdf;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RestaurantPDFController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'destroy',
            'DeletePDF'
        ]]);
        $this->middleware('editor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            if ($check_rows->user_role == 2) {
                //echo "Editor User";
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::where($where)->get());
                    }
                }

                return view('pdf.editor.index', [
                    'restaurants' => $restaurants
                ]);

            } else {
                $restaurants = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();
                return view('pdf.admin.index', [
                    'restaurants' => $restaurants
                ]);
            }
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function SearchPDF(Request $request)
    {
        try {

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    //echo $id->restaurant_id."<br>";
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::where($where)->get());
                    }
                }
                $restaurant_pdfs = DB::table('restaurant_pdfs')
                    ->select('restaurant_pdfs.id', 'restaurants.restaurant_name', 'pdf_file_name', 'pdf_title_th', 'pdf_title_en', 'pdf_title_cn')
                    ->join('restaurants', 'restaurant_pdfs.restaurant_id', '=', 'restaurants.id')
                    ->where('restaurant_pdfs.restaurant_id', $request->restaurant_id)->paginate(10);

                return view('pdf.editor.list', [
                    'restaurant_items' => $restaurants,
                    'restaurant_pdfs' => $restaurant_pdfs
                ]);
            } else {
                $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();
                $restaurant_pdfs = DB::table('restaurant_pdfs')
                    ->select('restaurant_pdfs.id', 'restaurants.restaurant_name', 'pdf_file_name', 'pdf_title_th', 'pdf_title_en', 'pdf_title_cn')
                    ->join('restaurants', 'restaurant_pdfs.restaurant_id', '=', 'restaurants.id')
                    ->where('restaurant_pdfs.restaurant_id', $request->restaurant_id)->paginate(10);

                return view('pdf.admin.list', [
                    'restaurant_items' => $restaurant_items,
                    'restaurant_pdfs' => $restaurant_pdfs
                ]);
            }
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

            $check_rows = User::find(Auth::id());
            $restaurants = array();

            if ($check_rows->user_role == 2) {
                $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($restaurant_id as $id) {
                    $arrays = explode(',', $id->restaurant_id, -1);
                    foreach ($arrays as $array) {
                        $where = ['id' => $array];
                        array_push($restaurants, Restaurants::where($where)->get());
                    }
                }

                return view('pdf.editor.editor_info', [
                    'restaurants' => $restaurants
                ]);

            } else {

                $restaurant_items = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();

                $restaurant_pdfs = DB::table('restaurant_pdfs')
                    ->select('restaurant_pdfs.id', 'restaurants.restaurant_name', 'pdf_file_name', 'pdf_title_th', 'pdf_title_en', 'pdf_title_cn')
                    ->join('restaurants', 'restaurant_pdfs.restaurant_id', '=', 'restaurants.id')
                    ->orderBy('restaurant_pdfs.id', 'ASC')->paginate(10);

                return view('pdf.admin.list', [
                    'restaurant_items' => $restaurant_items,
                    'restaurant_pdfs' => $restaurant_pdfs
                ]);
            }
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
        $filename = null;

        if (Input::hasFile('pdf')) {
            try {
                $filename = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $destinationPath = public_path('/pdf');
                $request->file('pdf')->move($destinationPath, $filename);
            } catch (FileException $e) {
                return view('error.index')->with('error', $e);
            }
        } else {
            $filename = null;
        }

        DB::beginTransaction();
        try {

            $restaurant_pdf = New RestaurantPdf;
            $restaurant_pdf->restaurant_id = $request->restaurant_id;
            $restaurant_pdf->pdf_file_name = $filename;
            $restaurant_pdf->pdf_title_th = $request->pdf_title_th;
            $restaurant_pdf->pdf_title_en = $request->pdf_title_en;
            $restaurant_pdf->pdf_title_cn = $request->pdf_title_cn;
            $restaurant_pdf->save();
            DB::commit();
            return redirect()->action('RestaurantPDFController@create');

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
            $restaurant_pdf = RestaurantPdf::find($id);
            if ($restaurant_pdf->pdf_file_name != null) {
                return response()->file(public_path('pdf/' . $restaurant_pdf->pdf_file_name));
            } else {
                return view('error.index')->with('error', 'File PDF not found');
            }
        } catch (FileException $e) {
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

            $restaurant_pdfs = DB::table('restaurant_pdfs')
                ->select('restaurant_pdfs.id', 'restaurant_id', 'restaurants.restaurant_name', 'pdf_file_name', 'pdf_title_th', 'pdf_title_en', 'pdf_title_cn')
                ->join('restaurants', 'restaurant_pdfs.restaurant_id', '=', 'restaurants.id')
                ->where('restaurant_pdfs.id', $id)->get();
            foreach ($restaurant_pdfs as $restaurant_pdf) {
            }

        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }

        $check_rows = User::find(Auth::id());
        $restaurants = array();

        if ($check_rows->user_role == 2) {
            $restaurant_id = DB::table('user_editors')->select('restaurant_id')->where('user_id', Auth::id())->get();
            foreach ($restaurant_id as $res_id) {
            }
            $arrays = explode(',', $res_id->restaurant_id, -1);
            foreach ($arrays as $array) {
                $where = ['id' => $array];
                array_push($restaurants, Restaurants::select('id', 'restaurant_name')->where($where)->get());
            }

            foreach ($arrays as $array) {
                if ($restaurant_pdf->restaurant_id == $array) {
                    return view('pdf.editor.edit', [
                        'restaurant_pdf_id' => $restaurant_pdf->id,
                        'restaurant_id' => $restaurant_pdf->restaurant_id,
                        'restaurant_name' => $restaurant_pdf->restaurant_name,
                        'pdf_file_name' => $restaurant_pdf->pdf_file_name,
                        'pdf_title_th' => $restaurant_pdf->pdf_title_th,
                        'pdf_title_en' => $restaurant_pdf->pdf_title_en,
                        'pdf_title_cn' => $restaurant_pdf->pdf_title_cn,
                    ])->with('restaurants', $restaurants);

                }
            }

        } else {
            $restaurants = Restaurants::select('id', 'restaurant_name')->orderBy('restaurant_name', 'ASC')->get();
            return view('pdf.admin.edit', [
                'restaurant_pdf_id' => $restaurant_pdf->id,
                'restaurant_id' => $restaurant_pdf->restaurant_id,
                'restaurant_name' => $restaurant_pdf->restaurant_name,
                'pdf_file_name' => $restaurant_pdf->pdf_file_name,
                'pdf_title_th' => $restaurant_pdf->pdf_title_th,
                'pdf_title_en' => $restaurant_pdf->pdf_title_en,
                'pdf_title_cn' => $restaurant_pdf->pdf_title_cn,
            ])->with('restaurants', $restaurants);
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
        $filename = null;

        if (Input::hasFile('pdf')) {
            try {
                $filename = time() . '.' . $request->file('pdf')->getClientOriginalExtension();
                $destinationPath = public_path('/pdf');
                $request->file('pdf')->move($destinationPath, $filename);
                $this->DeletePDF($id);
            } catch (FileException $e) {
                return view('error.index')->with('error', $e);
            }
        } else {
            $filename = $request->pdf_file_name;
        }

        DB::beginTransaction();
        try {
            DB::table('restaurant_pdfs')
                ->where('id', $id)
                ->update([
                    'restaurant_id' => $request->restaurant_id,
                    'pdf_file_name' => $filename,
                    'pdf_title_th' => $request->pdf_title_th,
                    'pdf_title_en' => $request->pdf_title_en,
                    'pdf_title_cn' => $request->pdf_title_cn
                ]);
            DB::commit();
            return redirect()->action('RestaurantPDFController@create');
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
            $this->DeletePDF($id);
            DB::table('restaurant_pdfs')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('RestaurantPDFController@create');
        } catch (Exception $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        }
    }

    public function DeletePDF($id)
    {
        try {
            $get_old_pdf = RestaurantPdf::find($id);
            return File::delete(public_path('pdf\\' . $get_old_pdf->pdf_file_name));
        } catch (FileException $e) {
            return view('error.index')->with('error', $e);
        }
    }
}

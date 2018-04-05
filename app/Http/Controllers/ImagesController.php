<?php

namespace App\Http\Controllers;

use DB;
use App\Image;
use App\Offers;
use File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'destroy'
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
            $offer_items = Offers::select('id', 'offer_name_en')->orderBy('id', 'ASC')->get();
            return view('image.index', [
                'offer_items' => $offer_items
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
        echo "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Input::hasFile('images')) {

            $collect = array();

            //Get old images from table images
            if (Image::where('offer_id', '=', $request->offer_id)->exists()) {

                $old_images = Image::select('image')->where('offer_id', $request->offer_id)->get();
                foreach ($old_images as $old_image) {
                    array_push($collect, $old_image->image);
                }
                $str_array = substr(implode(", ", $collect), 0, -1);
                //collect hav old images value
                $collect = explode(',', $str_array);
            }

            if ($files = $request->file('images')) {
                try {
                    foreach ($files as $file) {
                        $name = rand() . "." . $file->getClientOriginalExtension();
                        $destinationPath = public_path('/images');
                        $file->move($destinationPath, $name);
                        $images[] = $name;
                        array_push($collect, $name);

                    }
                } catch (FileException $e) {
                    return view('error.index')->with('error', $e);
                }
            }

            DB::beginTransaction();
            try {
                if (Image::where('offer_id', '=', $request->offer_id)->exists()) {

                    DB::table('images')
                        ->where('offer_id', $request->offer_id)
                        ->update([
                            'image' => implode(',', $collect) . ","
                        ]);
                    DB::commit();
                    return redirect()->action('ImagesController@create');
                } else {
                    $images = new Image;
                    $images->offer_id = $request->offer_id;
                    $images->image = implode(",", $collect) . ",";
                    $images->save();
                    DB::commit();
                    return redirect()->action('ImagesController@create');
                }
            } catch (QueryException $e) {
                DB::rollback();
                return view('error.index')->with('error', $e);
            } catch (Exception $e) {
                return view('error.index')->with('error', $e);
            }
        }else{
            return view('error.index')->with('error', 'Image upload not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}

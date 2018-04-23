<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\ImagesRequest;
use App\UserEditor;
use DB;
use App\Images;
use App\Offers;
use File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => [
            'destroy',
            'DeleteAllImage'
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

            $offer_items = array();
            $check_rows = User::find(Auth::id());
            $view = null;

            if ($check_rows->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->get();
                foreach ($user_editors as $user_editor) {
                    $restaurants_id = explode(',', $user_editor->restaurant_id);
                    foreach ($restaurants_id as $id) {
                        if (Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->exists()) {
                            array_push($offer_items, Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->get());
                        }

                    }
                }

                $view = 'image.editor.index';

            } else {
                $offer_items = Offers::select('id', 'offer_name_en')->orderBy('id', 'ASC')->get();
                $view = 'image.admin.index';
            }

            return view($view, [
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
        try {

            $offer_items = array();
            $check_rows = User::find(Auth::id());

            if ($check_rows->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($user_editors) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($user_editors as $user_editor) {
                        $restaurants_id = explode(',', $user_editor->restaurant_id);
                        foreach ($restaurants_id as $id) {
                            if (Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->exists()) {
                                array_push($offer_items, Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->get());
                            }
                        }
                    }
                    return view('image.editor.editor_info', [
                        'offer_items' => $offer_items
                    ]);
                }
            } else {

                $offer_items = Offers::select('id', 'offer_name_en')->orderBy('id', 'ASC')->get();
                $images = DB::table('images')
                    ->select('images.id', 'offer_name_en', 'image', 'hotels.hotel_name', 'restaurants.restaurant_name')
                    ->join('offers', 'offers.id', '=', 'images.offer_id')
                    ->join('hotels', 'hotels.id', '=', 'offers.hotel_id')
                    ->join('restaurants', 'restaurants.id', '=', 'offers.restaurant_id')
                    ->orderBy('images.id', 'asc')->paginate(10);

                foreach ($images as $image) {

                }

                reset($images);

                return view('image.admin.list', [
                    'offer_items' => $offer_items,
                    'images' => $images
                ]);
            }
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public function SearchImage(Request $request)
    {
        try {

            $offer_items = array();
            $view = null;
            $where = null;

            $check_rows = User::find(Auth::id());

            if ($check_rows->user_role == 2) {
                $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->get();
                if (count($user_editors) == 0) {
                    return view('error.index')->with('error', 'You never match with restaurant');
                } else {
                    foreach ($user_editors as $user_editor) {
                        $restaurants_id = explode(',', $user_editor->restaurant_id);
                        foreach ($restaurants_id as $id) {
                            if (Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->exists()) {
                                array_push($offer_items, Offers::select('id', 'offer_name_en')->where('restaurant_id', '=', $id)->get());
                            }
                        }
                    }
                    $where = ['images.offer_id' => $request->offer_id];
                    $view = 'image.editor.list';
                }
            } else {
                $offer_items = Offers::select('id', 'offer_name_en')->orderBy('id', 'ASC')->get();
                $where = ['images.offer_id' => $request->offer_id];
                $view = 'image.admin.list';
            }

            $images = DB::table('images')
                ->select('images.id', 'offer_name_en', 'image', 'hotels.hotel_name', 'restaurants.restaurant_name')
                ->join('offers', 'offers.id', '=', 'images.offer_id')
                ->join('hotels', 'hotels.id', '=', 'offers.hotel_id')
                ->join('restaurants', 'restaurants.id', '=', 'offers.restaurant_id')
                ->where($where)->paginate(10);

            foreach ($images as $image) {

            }

            reset($images);

            return view($view, [
                'offer_items' => $offer_items,
                'images' => $images
            ]);

        } catch
        (QueryException $e) {

        } catch (Exception $e) {

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
        if (Input::hasFile('images')) {

            $collect = array();

            //Get old images from table images
            if (Images::where('offer_id', '=', $request->offer_id)->exists()) {

                $old_images = Images::select('image')->where('offer_id', $request->offer_id)->get();
                foreach ($old_images as $old_image) {
                    if ($old_image->image != "") {
                        array_push($collect, $old_image->image);
                    }
                }
            }

            if ($files = $request->file('images')) {
                try {
                    $arrays = ['jpg', 'jpeg', 'png', 'gif'];
                    foreach ($files as $file) {
                        $type = $file->getClientOriginalExtension();
                        foreach ($arrays as $array) {
                            if ($type == $array) {

                                $name = rand() . "." . $file->getClientOriginalExtension();
                                $new_file_name = rand() . "." . $file->getClientOriginalExtension();

                                $destinationPath = public_path('/images');
                                $file->move($destinationPath, $name);

                                Image::make($destinationPath . '/' . $name)->resize(800, 400)->save($destinationPath . '/' . $new_file_name);
                                File::delete(public_path('images\\' . $name));

                                $images[] = $new_file_name;
                                array_push($collect, $new_file_name);
                            }
                        }
                    }
                } catch
                (FileException $e) {
                    return view('error.index')->with('error', $e);
                }
            }

            DB::beginTransaction();
            try {
                if (Images::where('offer_id', '=', $request->offer_id)->exists()) {

                    DB::table('images')
                        ->where('offer_id', $request->offer_id)
                        ->update([
                            'image' => implode(',', $collect)
                            //'image' => substr(implode(','))
                        ]);
                    DB::commit();
                    return redirect()->action('ImagesController@create');
                } else {
                    $images = new Images;
                    $images->offer_id = $request->offer_id;
                    $images->image = implode(",", $collect);
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
        } else {
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
        if (Images::where('id', '=', $id)->exists()) {
            try {

                $photos = array();
                $offers_id = array();
                $view = null;

                $images = DB::table('images')
                    ->select('images.id', 'images.offer_id', 'offer_name_en', 'image')
                    ->join('offers', 'offers.id', '=', 'images.offer_id')
                    ->where('images.id', $id)->get();

                foreach ($images as $image) {
                    // ตัดข้อความจากตัวแรก a ไปจนถึง ตัว e โดยตัดข้อความที่นับจากหลังมา 1 ตัวออกไป
                    //$sub_str = substr($image->image, 1);  // returns "cde"
                    if ($image->image == "") {
                        return view('error.index')->with('error', 'Don`t have images to show');
                    } else {
                        $photos = explode(',', $image->image);
                    }
                }

                $check_rows = User::find(Auth::id());
                if ($check_rows->user_role == 2) {
                    $user_editors = UserEditor::select('restaurant_id')->where('user_id', Auth::id())->get();
                    foreach ($user_editors as $user_editor) {
                        $restaurants_id = explode(',', $user_editor->restaurant_id);
                        foreach ($restaurants_id as $restaurant_id) {
                            $where = ['id' => $image->offer_id, 'restaurant_id' => $restaurant_id];
                            if (Offers::where($where)->exists()) {
                                $view = 'image.editor.edit';
                            }
                        }
                        if (!isset($view)) {
                            return view('error.index')->with('error', 'You don`t have permission');
                        }
                    }
                } else {
                    $view = 'image.admin.edit';
                }

                return view($view, [
                    'id' => $image->id,
                    'offer_id' => $image->offer_id,
                    'offer_name' => $image->offer_name_en,
                    'photos' => $photos
                ]);

            } catch
            (Exception $e) {
                return view('error.index')->with('error', $e);
            }
        } else {
            return view('error.index')->with('error', 'Search not found');
        }
    }

//Unset Array Item
    public
    function UnsetItem($id, array $items)
    {
        try {
            $old_images = Images::find($id);
            $old_images_array = explode(',', $old_images->image);
            reset($old_images_array);

            foreach ($items as $item) {
                foreach ($old_images_array as $i => $row) {
                    if ($row == $item) {
                        unset($old_images_array[$i]);
                    }
                }
            }

            return $old_images_array;

        } catch (QueryException $e) {
            throw new  QueryException($e);
        } catch (Exception $e) {
            throw  new Exception("Unset array item exception");
        }

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

        $new_images = null;

        if ($request->input('images') == null) {
            $images = Image::find($id);
            $new_images = $images->image;
        } else {
            $result = $this->UnsetItem($id, $request->input('images'));
            $reset_index = array_values($result);
            $new_images = implode(',', $reset_index);

            try {
                foreach ($request->input('images') as $image) {
                    File::delete(public_path('images\\' . $image));
                }
            } catch (FileException $e) {
                return view('error.index')->with('error', $e);
            }
        }

        DB::beginTransaction();
        try {
            DB::table('images')
                ->where('id', $id)
                ->update([
                    'image' => $new_images
                ]);
            DB::commit();
            return redirect()->action('ImagesController@create');
        } catch (QueryException $e) {
            return view('error.index')->with('error', $e);
        }
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
        DB::beginTransaction();
        try {
            $this->DeleteAllImage($id);
            DB::table('images')->where('id', $id)->delete();
            DB::commit();
            return redirect()->action('ImagesController@create');
        } catch (QueryException $e) {
            DB::rollback();
            return view('error.index')->with('error', $e);
        } catch (Exception $e) {
            return view('error.index')->with('error', $e);
        }
    }

    public
    function DeleteAllImage($id)
    {
        try {
            $old_images = Images::find($id);
            $old_images_array = explode(',', $old_images->image);
            reset($old_images_array);

            foreach ($old_images_array as $item) {
                File::delete(public_path('images\\' . $item));
            }

        } catch (FileException $e) {
            throw new FileException("File delete exception");
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 03/04/2018
 * Time: 2:46 PM
 */

namespace App\Library;

use File;
use App\Offers;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class FileUploadManage
{
    public function __construct()
    {

    }

    /*public function UploadImage(Request $request)
    {
        try {
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $request->file('image')->move($destinationPath, $filename);
            return $filename;
        } catch (FileException $e) {
            throw new Exception($e);
        } catch (Exception $e) {
            throw  new Exception($e);
        }
    }

    public function DeleteImage($id)
    {
        try {
            $get_old_image = Offers::find($id);
            return File::delete(public_path('images\\' . $get_old_image->image));
        } catch (FileException $e) {
            throw new Exception($e);
        } catch (Exception $e) {
            throw  new Exception($e);
        }
    }*/


}
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {

        $image = $request->file('image');

        if (!empty($image)) {

            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            //         save image name in temp_images table
            $temImage  = new TempImage();
            $temImage->name = $imageName;
            $temImage->save();

            //  store image in public/temp_images folder
            $destinationPath = public_path('temp_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            return response()->json([
                'status' => true,
                'image_id' => $temImage->id,
                'message' => 'Image uploaded successfully',
                'image_name' => $imageName,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Image is required',
            ]);
        }
    }
}

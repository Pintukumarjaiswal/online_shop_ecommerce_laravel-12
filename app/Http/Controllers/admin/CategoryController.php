<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $category = Category::latest();
        if (!empty($request->input('table_search'))) {
            $search = $request->input('table_search');
            $category = Category::where('name', 'like', "%$search%");
        }
        $category = $category->paginate((10));

        return view('admin.category.list', compact('category'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->save();

        // save  image here 

        if (!empty($request->image_id)) {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.', $tempImage->name);
            // dd($extArray);
            $ext = last($extArray);
            // dd($ext);
            $newImageName = $category->id . '.' . $ext;
            $sPath = public_path('temp_images/') . $tempImage->name;
            $dPath = public_path('uploads/category/') . $newImageName;
            if (!file_exists(public_path('uploads/category'))) {
                mkdir(public_path('uploads/category'), 0755, true);
            }
            File::copy($sPath, $dPath);
            $category->image = $newImageName;
            $category->save();
        }

        $request->session()->flash('success', 'Category Created Successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully'
        ]);
    }

    public function edit() {}

    public function update() {}

    public function destroy() {}
}

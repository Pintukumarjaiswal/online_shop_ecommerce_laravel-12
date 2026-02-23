<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {

        $category = Category::orderBy('name', 'ASC')->get();
        return view('sub_category.create', compact('category'));
    }

    public function list(Request $request)
{
    $subCategories = SubCategory::join('categories', 'sub_category.categoryId', '=', 'categories.id')
        ->select('sub_category.*', 'categories.name as category_name');

     if (!empty($request->input('table_search'))) {
            $search = $request->input('table_search');
            $subCategories = SubCategory::where('name', 'like', "%$search%");
        }

    // Paginate (NO get() before this)
    $subCategories = $subCategories->paginate(10);

    return view('sub_category.list', compact('subCategories'));
}

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_category,slug',
            'categoryId' => 'required',
            'status' => 'required'


        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors(),
                'message' => "Valodation error"
            ]);
        }

        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        $subcategory->categoryId = $request->categoryId;

        $subcategory->save();

        $request->session()->flash('success', 'Sub_Category Created Successfully');

        return response()->json([
            'status' => true,
            'data' => $subcategory,
            'message' => "sub_category created successfully",
        ]);
        // dd($request);
    }
}

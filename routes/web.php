<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

    Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');

    Route::middleware(['auth', 'role:2'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        // Category Route Management
        Route::get('/categories', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/list', [CategoryController::class, 'index'])->name('categories.list');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Temporary Route for Category List
        Route::post('/temp-image-create', [TempImagesController::class, 'create'])->name('temp-images.create');

        // Sub_Category_Route Here.....===================================
        Route::get('/sub-category/create', [SubCategoryController::class, 'index'])->name('subcategory.create');
        Route::post('/sub-categories', [SubCategoryController::class, 'store'])->name('subcategories.store');
        Route::get('/sub-categories/list', [SubCategoryController::class, 'list'])->name('subcategories.list');
    });






    Route::get('/getslug', function (Request $request) {
        $slug = '';
        if (!empty($request->name)) {
            $slug = Str::slug($request->name);
            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        }
    })->name('getSlug');

    Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/dashboard/user', function () {
            return "User Dashboard";
        })->name('user.dashboard');
    });
});

// });
// }'])
// Route::get('admin/login',[AdminLoginController::class,'index'])->name('admin.login');

Route::fallback(function () {
    return "Route Not Found";
});

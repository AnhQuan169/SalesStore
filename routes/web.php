<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryProduct;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Client
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);


// Admin
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);

//  ------------ Quản lí danh mục sẳn phẩm
// Mở cửa sổ thêm danh mục sản phẩm mới
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);
//  Lưu danh mục sản phẩm được thêm vào
Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
// Hiển thị/Ẩn danh mục sản phẩm
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);
Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
// Mở cửa sổ cập nhật danh mục sản phẩm
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
// Lưu danh mục sản phẩm được chỉnh sửa
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);
// Xoá danh mục sản phẩm được chọn
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);


//  -------------Quản lí thương hiệu sản phẩm
// Mở cửa sổ thêm thương hiệu sản phẩm mới
Route::get('/add-brand', [BrandController::class, 'add_brand']);
Route::get('/all-brand', [BrandController::class, 'all_brand']);
//  Lưu thương hiệu sản phẩm được thêm vào
Route::post('/save-brand', [BrandController::class, 'save_brand']);
// Hiển thị/Ẩn thương hiệu sản phẩm
Route::get('/active-brand/{brand_id}', [BrandController::class, 'active_brand']);
Route::get('/unactive-brand/{brand_id}', [BrandController::class, 'unactive_brand']);
// Mở cửa sổ cập nhật thương hiệu sản phẩm
Route::get('/edit-brand/{brand_id}', [BrandController::class, 'edit_brand']);
// Lưu thương hiệu sản phẩm được chỉnh sửa
Route::post('/update-brand/{brand_id}', [BrandController::class, 'update_brand']);
// Xoá thương hiệu sản phẩm được chọn
Route::get('/delete-brand/{brand_id}', [BrandController::class, 'delete_brand']);

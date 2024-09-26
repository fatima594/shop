<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dashboard\ContactController;
use App\Http\Controllers\dashboard\DetailsController;
use App\Http\Controllers\dashboard\OrderController;
use App\Http\Controllers\dashboard\SubscriberController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ProductController;

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

//
Route::get('/', function () {
    $products = Product::all(); // تحميل الفئة مع المنتج
    $categories = Category::all();

    return view('layouts.pages.master', compact('products', 'categories'));
});

Route::get('/category', function () {
    $categories = Category::all();
    return view('layouts.pages.category' , compact('categories'));
});


Route::get('/products', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('layouts.pages.products' , compact('products' , 'categories'));
});


//Route::get('/single/{slug}', [DetailsController::class, 'show'])->name('products.single');

Route::get('/about', function () {
    return view('layouts.pages.about');
});


Route::get('/product', function () {
    $products = Product::all();
    return view('layouts.pages.products', ['products' => $products]);
});


//   details contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');




//   details routes

Route::prefix('details')->group(function () {
    Route::get('/product/{slug}', [DetailsController::class, 'show'])->name('product.show');
    Route::get('category/{categoryId}', [DetailsController::class, 'indexByCategory'])->name('products.indexByCategory');

});

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');


//   cart routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

//orders routes

Route::middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});





// Admin routes with prefix 'admin'
Route::prefix('admin')->name('admin.')->group(function () {
    // Show admin login form
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    // Handle admin login
    Route::post('/login', [AdminController::class, 'adminlogin'])->name('login.submit');
    // Show admin registration form
    Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('register');
    // Handle admin registration
    Route::post('/register', [AdminController::class, 'adminregister'])->name('register.submit');



    Route::middleware('auth:admin')->group(function () {
        // Show admin dashboard
        Route::get('/index', [AdminController::class, 'dashboard'])->name('index');
//for categories
        Route::get('admin/category', [CategoryController::class, 'index'])->name('category.index');
// عرض نموذج الإدخال
        Route::get('admin/category/create', [CategoryController::class, 'create'])->name('category.create');
// حفظ البيانات
        Route::post('admin/category', [CategoryController::class, 'store'])->name('category.store');
// عرض نموذج التعديل
        Route::get('admin/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
// تحديث البيانات
        Route::put('admin/category/{category}', [CategoryController::class, 'update'])->name('category.update');
// حذف البيانات
        Route::delete('admin/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
// عرض تفاصيل منشور واحد
        Route::get('admin/category/{id}', [CategoryController::class, 'show'])->name('category.show');


// عرض جميع المنتجات
        Route::get('admin/products', [ProductController::class, 'index'])->name('products.index');

// عرض نموذج الإدخال
        Route::get('admin/products/create', [ProductController::class, 'create'])->name('products.create');

// حفظ البيانات
        Route::post('admin/products', [ProductController::class, 'store'])->name('products.store');

// عرض نموذج التعديل
        Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// تحديث البيانات
        Route::put('admin/products/{product}', [ProductController::class, 'update'])->name('products.update');

// حذف البيانات
        Route::delete('admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// عرض تفاصيل منتج واحد
        Route::get('admin/products/{product}', [ProductController::class, 'show'])->name('products.show');


    });

});

require __DIR__.'/auth.php';

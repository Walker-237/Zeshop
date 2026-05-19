<?php

use Illuminate\Support\Facades\Route;
use Shopper\Core\Models\Product;
use Shopper\Core\Models\Brand;
use Shopper\Core\Models\Category;
use Shopper\Core\Models\Collection;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    $categories  = Category::where('is_enabled', true)->get();
    $trending  = Product::where('is_visible', true)->with('prices', 'brand')->latest()->take(5)->get();
    $flashDeals = Product::where('is_visible', true)->with('prices', 'brand')
                        ->whereHas('prices', fn($q) => $q->whereNotNull('compare_amount'))
                        ->take(4)->get();
    $browse    = Product::where('is_visible', true)->with('prices', 'brand')->latest()->take(12)->get();
    $suggested = Product::where('is_visible', true)->with('prices', 'brand')->inRandomOrder()->take(4)->get();
    $collections = Collection::withCount('products')->get();
    $brands      = Brand::where('is_enabled', true)->take(10)->get();

    return view('welcome', compact(
        'categories',
        'trending',
        'flashDeals',
        'browse',
        'collections',
        'suggested',
        'brands',
    ));
})->name('home');

Route::get('/products', function () {
    $categories = Category::where('is_enabled', true)->get();
    $brands     = Brand::where('is_enabled', true)->get(); // add this
    $products   = Product::where('is_visible', true)
                    ->with('prices', 'brand', 'categories')
                    ->paginate(12);

    return view('products.index', compact('categories', 'brands', 'products'));
})->name('products.index');

Route::get('/products/{slug}', function ($slug) {
    $product = \Shopper\Core\Models\Product::where('slug', $slug)
                ->with('prices', 'brand', 'categories')
                ->firstOrFail();
    $categories = Category::where('is_enabled', true)->get();
    $category = $product->categories()->first();
    $products = Product::where('is_visible', true)
                ->where('id', '!=', $product->id)
                ->with('prices', 'brand')
                ->inRandomOrder()
                ->take(4)
                ->get();
    return view('products.show', compact('product', 'category', 'categories', 'products'));
})->name('products.show');

Route::get('/categories/{slug}', function ($slug) {
    $category   = Category::where('slug', $slug)
                    ->where('is_enabled', true)
                    ->firstOrFail();

    $categories = Category::where('is_enabled', true)->get(); // add this

    $products   = Product::where('is_visible', true)
                    ->with('prices', 'brand')
                    ->whereHas('categories', fn($q) => $q->where('slug', $slug))
                    ->paginate(12);

    return view('categories.show', compact('category', 'categories', 'products'));
})->name('categories.show');

Route::get('/wishlist', function () {
    $categories = \Shopper\Core\Models\Category::select('id', 'name', 'slug')->get();
    return view('wishlist', compact('categories'));
})->name('wishlist');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{index}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{index}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');

// Auth

Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [CustomerLoginController::class, 'store'])->name('login.store');

    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [CustomerRegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomerLoginController::class, 'destroy'])->name('logout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/account', function () {
        $categories = Category::where('is_enabled', true)->get();
        return view('account.index', compact('categories'));
    })->name('account');

    Route::get('/checkout', function () {
        $categories = Category::where('is_enabled', true)->get();
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('checkout', compact('categories', 'cart', 'total'));
    })->name('checkout');
});
<?php

use Illuminate\Support\Facades\Route;
use Shopper\Core\Models\Product;
use Shopper\Core\Models\Brand;
use Shopper\Core\Models\Category;
use Shopper\Core\Models\Collection;

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
    return view('products.show', compact('product'));
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

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Auth
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Account (protected)
Route::middleware('auth')->group(function () {
    Route::get('/account', function () {
        return view('account.index');
    })->name('account');

    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');
});

use App\Livewire\Inventory\Index as InventoryIndex;
use App\Livewire\Inventory\Adjust as InventoryAdjust;

Route::middleware(['auth'])->prefix('cpanel')->group(function () {
    Route::get('/inventory', InventoryIndex::class)->name('inventory.index');
    Route::get('/inventory/{productId}/adjust', InventoryAdjust::class)->name('inventory.adjust');
});
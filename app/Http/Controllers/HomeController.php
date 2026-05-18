<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shopper\Core\Models\Product;
use Shopper\Core\Models\Category;
use Shopper\Core\Models\Brand;
use Shopper\Core\Models\Collection;

class HomeController extends Controller
{
    public function index()
    {
        // Trending: latest 5 active products
        $trending = Product::with(['brand', 'media'])
            ->where('is_visible', true)
            ->latest()
            ->take(5)
            ->get();

        // Browse: latest 12 active products
        $browse = Product::with(['brand', 'media', 'categories'])
            ->where('is_visible', true)
            ->latest()
            ->take(12)
            ->get();

        // Flash deals: 4 products with old_price set (on sale)
        $flashDeals = Product::with(['brand', 'media'])
            ->where('is_visible', true)
            ->whereNotNull('compare_at_price')
            ->latest()
            ->take(4)
            ->get();

        // You might also like: 4 random products
        $suggested = Product::with(['brand', 'media'])
            ->where('is_visible', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Categories for nav pills
        $categories = Category::where('is_enabled', true)
            ->withCount('products')
            ->take(8)
            ->get();

        // Brands for brands bar
        $brands = Brand::where('is_enabled', true)
            ->take(12)
            ->get();

        // Collections for curated section
        $collections = Collection::take(4)->get();

        return view('welcome', compact(
            'trending',
            'browse',
            'flashDeals',
            'suggested',
            'categories',
            'brands',
            'collections'
        ));
    }
}
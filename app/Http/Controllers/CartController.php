<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shopper\Core\Models\Product;
use Shopper\Core\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $cart       = session('cart', []);
        $total      = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $categories = Category::select('id', 'name', 'slug')->get(); 

        return view('cart', compact('cart', 'total', 'categories')); 
    }

    // Add to cart
    public function add(Request $request, Product $product)
    {
        $cart = session('cart', []);

        // Check if product already in cart
        foreach ($cart as &$item) {
            if ($item['id'] === $product->id) {
                $item['quantity'] += $request->input('quantity', 1);
                session(['cart' => $cart]);
                return back()->with('success', 'Cart updated!');
            }
        }

        // Add new item
        $cart[] = [
            'id'       => $product->id,
            'name'     => $product->name,
            'slug'     => $product->slug,
            'price'    => $product->price,
            'image'    => $product->image,
            'quantity' => $request->input('quantity', 1),
        ];

        session(['cart' => $cart]);
        return back()->with('success', 'Added to cart!');
    }

    // Update quantity
    public function update(Request $request, $index)
    {
        $cart = session('cart', []);

        if (isset($cart[$index])) {
            $cart[$index]['quantity'] = max(1, (int) $request->input('quantity', 1));
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart updated!');
    }

    // Remove item
    public function remove($index)
    {
        $cart = session('cart', []);

        if (isset($cart[$index])) {
            array_splice($cart, $index, 1);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Item removed.');
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    // Sync cart from client to session
    public function sync(Request $request)
    {
        $items = $request->validate([
            'items'               => ['required', 'array'],
            'items.*.product_id'  => ['required', 'integer'],
            'items.*.name'        => ['required', 'string'],
            'items.*.price'       => ['required', 'numeric'],
            'items.*.quantity'    => ['required', 'integer'],
            'items.*.image'       => ['nullable', 'string'],
            'items.*.slug'        => ['nullable', 'string'],
        ]);

        // Normalize to match what OrderController expects
        $normalized = array_map(fn($item) => [
            'id'       => $item['product_id'],
            'name'     => $item['name'],
            'price'    => $item['price'],
            'quantity' => $item['quantity'],
            'image'    => $item['image'] ?? null,
            'slug'     => $item['slug'] ?? null,
        ], $items['items']);

        session(['cart' => $normalized]);

        return response()->json(['success' => true]);
    }
}
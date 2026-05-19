<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\Category;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => ['required', 'string'],
            'last_name'      => ['required', 'string'],
            'email'          => ['required', 'email'],
            'phone'          => ['required', 'string'],
            'city'           => ['required', 'string'],
            'street_address' => ['required', 'string'],
            'payment'        => ['required', 'string'],
            'notes'          => ['nullable', 'string'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        DB::transaction(function () use ($request, $cart, $total) {

            // 1. Create shipping address
            $address = DB::table('sh_order_addresses')->insertGetId([
                'customer_id'    => auth()->id(),
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'phone'          => $request->phone,
                'city'           => $request->city,
                'street_address' => $request->street_address,
                'country_name'   => 'Cameroon',
                'postal_code'    => $request->postal_code ?? '',  
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // 2. Create the order
            $order = Order::create([
                'number'              => 'ORD-' . strtoupper(uniqid()),
                'customer_id'         => auth()->id(),
                'status'              => 'pending',
                'currency_code'       => 'XAF',
                'price_amount'        => $total,
                'notes'               => $request->notes,
                'shipping_address_id' => $address,
                'billing_address_id'  => $address,
                'metadata'            => json_encode([
                    'payment_method' => $request->payment,
                    'email'          => $request->email,
                ]),
            ]);

            // 3. Create order items
            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id'       => $item['id'],
                    'name'             => $item['name'],
                    'quantity'         => $item['quantity'],
                    'unit_price_amount'=> $item['price'],
                    'product_type'     => \Shopper\Core\Models\Product::class,
                ]);
            }

            // 4. Clear cart
            session()->forget('cart');
        });

        return redirect()->route('account')->with('success', 'Order placed successfully!');
    }
}
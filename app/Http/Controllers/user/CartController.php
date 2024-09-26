<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;



class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Assuming a flat shipping cost for simplicity
        $shipping = 7;
        $total = $subtotal + $shipping;

        return view('layouts.pages.cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(CartRequest $request)
    {
        $validatedData = $request->validated();

        // Find the product
        $product = Product::findOrFail($validatedData['product_id']);

        // Check if the product already exists in the cart for the current user
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $validatedData['product_id'])
            ->first();

        if ($cartItem) {
            // If the product already exists in the cart, update the quantity
            Log::info('Product already exists in the cart, updating quantity.');
            $cartItem->quantity += $validatedData['quantity'];
            $cartItem->save();
        } else {
            // Otherwise, create a new cart item with the product
            Log::info('Adding new product to the cart.');
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $validatedData['product_id'],
                'quantity' => $validatedData['quantity'],
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }


    /**
     * Update the cart.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove a product from the cart.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}

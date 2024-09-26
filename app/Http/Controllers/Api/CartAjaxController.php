<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartAjaxController extends Controller
{
    public function index()
    {
        // استرجاع عناصر السلة مع معلومات المنتج
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->paginate(10);

        // إعادة البيانات باستخدام Resource
        return CartItemResource::collection($cartItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => DB::raw('quantity + ' . $request->quantity)]
        );

        return response()->json(['message' => 'Product added to cart successfully.', 'cart_item' => $cartItem], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->update(['quantity' => $request->quantity]);
        return response()->json(['message' => 'Cart item updated successfully.']);
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->delete();
        return response()->json(['message' => 'Cart item removed successfully.']);
    }


}

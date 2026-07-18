<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $id = Auth::user()->id;

        $cart = Cart::with(['cartItems' => function ($query) {
            return $query->orderBy('created_at', 'desc');
        }, 'cartItems.foodItem'])->where('user_id', $id)->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'cart is empty',
                'total_items' => 0,
                'items' => 0,
                'summery' => [
                    'total_items' => 0,
                    'total' => 0
                ]
            ], 200);
        }
        $cart_items = $cart->cartItems;

        $total_items = $cart_items->sum('quantity');
        $total_amount = $cart_items->sum(function ($item) {
            return $item->quantity * $item->foodItem->price;
        });
        return response()->json([
            'status' => true,
            'message' => 'All Cart items',
            'total_items' => count($cart_items),
            'items' => $cart_items,
            'summery' => [
                'total_items' => $total_items,
                'total' => $total_amount
            ]
        ], 200);
    }

    public function totalCartItems()
    {
        $cart = Cart::with(['cartItems'])->where('user_id', Auth::user()->id)->first();
        if (!$cart) {
            return response()->json([
                'status' => false,
                'total_items' => 0
            ], 200);
        }
        $cart_items = $cart->cartItems;
        return response()->json([
            'status' => true,
            'total_items' => count($cart_items)
        ], 200);
    }

    public function store(Request $request)
    {
        $validate_request = $request->validate([
            'food_item_id' => 'required',
            'quantity' => 'nullable'
        ]);

        $id = Auth::user()->id;
        $food_item = FoodItem::find($request->food_item_id);
        $cart = Cart::where('user_id', $id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $id
            ]);
        }
        $cart_item = CartItem::where('cart_id', $cart->id)->where('food_item_id', $request->food_item_id)->first();
        if (!$cart_item) {
            $cart_item = CartItem::create([
                'cart_id' => $cart->id,
                'food_item_id' => $food_item->id,
                'quantity' => $request->quantity,
                'price' => $food_item->price
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Cart item added successfully'
            ], 201);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'This item is already added'
            ]);
        }
    }

    public function increase_quantity(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $cart_item = CartItem::where('cart_id', $cart->id)->where('food_item_id', $request->food_item_id)->first();
        $cart_item->increment('quantity');

        // latest cart items
        $cart_items = CartItem::with('foodItem')->where('cart_id', $cart->id)->get();
        $total_cart_items = CartItem::where('cart_id', $cart->id)->get();
        $total_items = $total_cart_items->sum('quantity');
        $total_amount = $total_cart_items->sum(function ($item) {
            return $item->quantity * $item->foodItem->price;
        });

        return response()->json([
            'status' => true,
            'items' => $cart_items,
            'summery' => [
                'total_items' => $total_items,
                'total' => $total_amount
            ]
        ], 200);
    }
    public function decrease_quantity(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();
        $cart_item = CartItem::where('cart_id', $cart->id)->where('food_item_id', $request->food_item_id)->first();
        $cart_item->decrement('quantity');
        // latest cart items
        $cart_items = CartItem::with('foodItem')->where('cart_id', $cart->id)->get();
        $total_cart_items = CartItem::where('cart_id', $cart->id)->get();
        $total_items = $total_cart_items->sum('quantity');
        $total_amount = $total_cart_items->sum(function ($item) {
            return $item->quantity * $item->foodItem->price;
        });
        if ($cart_item->save()) {
            return response()->json([
                'status' => true,
                'items' => $cart_items,
                'summery' => [
                    'total_items' => $total_items,
                    'total' => $total_amount
                ]
            ], 200);
        }
    }

    public function destroy($item_id)
    {
        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id', $user_id)->first();
        $cart_item = CartItem::where('cart_id', $cart->id)->where('food_item_id', $item_id)->first();
        if ($cart_item->delete()) {
            $updated_cart_items = CartItem::with('foodItems')->where('cart_id', $cart->id)->get();
            $total_cart_items = CartItem::where('cart_id', $cart->id)->get();
            $total_items = $total_cart_items->sum('quantity');
            $total_amount = $total_cart_items->sum(function ($item) {
                return $item->quantity * $item->foodItem->price;
            });
            return response()->json([
                'status' => true,
                'items' => $updated_cart_items,
                'summery' => [
                    'total_items' => $total_items,
                    'total' => $total_amount
                ]
            ]);
        }
    }
}
